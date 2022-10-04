<?php

/**
 * @file
 * EloquentSection
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Schedule;

use App\Repositories\Schedule\ScheduleInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Section;

class EloquentSchedule implements ScheduleInterface
{

  /**
   * Section
   *
   * @var App\Models\Schedule;
   *
   */
  protected $Schedule;

  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $Schedule, DB $DB)
  {
    $this->Schedule = $Schedule;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of Sections
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null, $customQuery = null)
  {
    $query = $this->DB::table('schedules AS s')
      ->select(
        's.id',

         $this->DB::raw('CONCAT(s.start_hour, \'-\', s.end_hour) AS horario'),

      )
     ->where('s.day_of_week', '=', 1)
      ->whereNull('s.deleted_at');

    if (!empty($customQuery)) {
      $query->whereNested(function ($dbQuery) use ($customQuery) {
        foreach ($customQuery as $statement) {

          if($statement['op'] == 'is not in')
          {
            $dbQuery->whereNotIn($statement['field'], explode(',',$statement['data']));
            continue;
          }

          if($statement['op'] == 'is null')
          {
            $dbQuery->whereNull($statement['field']);
            continue;
          }

          if($statement['op'] == 'is not null')
          {
            $dbQuery->whereNotNull($statement['field']);
            continue;
          }

          $dbQuery->where($statement['field'], $statement['op'], $statement['data']);
        }
      });
    }

    if (!empty($filter)) {
      $query->where(function ($dbQuery) use ($filter) {
        foreach (['s.day_of_week'] as $key => $value) {
          $dbQuery->orWhere($value, 'like', '%' . str_replace(' ', '%', $filter) . '%');
          //$dbQuery->orwhereRaw('lower(`' . $value . '`) LIKE ? ',['%' . strtolower(str_replace(' ', '%', $filter)) . '%']);
        }
      });
    }

    if (!empty($sortColumn) && !empty($sortOrder)) {
      $query->orderBy($sortColumn, $sortOrder);
    }

    if ($count) {
      return $query->count();
    }

    if (!empty($limit)) {
      $query->take($limit);
    }

    if (!empty($offset) && $offset != 0) {
      $query->skip($offset);
    }
    return new Collection(
      $query->get()
    );
  }

  /**
   * Get an Section by id
   *
   * @param  int $id
   *
   * @return App\Models\Section
   */
  public function byId($id)
  {
    $ids = get_keys_data($id);

    return $this->Schedule
      ->where('id', intval($ids[0]))
      ->whereNull('deleted_at')
      ->first();
  }

  /**
   * Get an Section by id
   *
   * @param  int $id
   *
   * @return App\Models\Schedule
   */
  public function countCurriculumSubjectByPeriod($curriculumSubjectId, $periodId)
  {
    return $this->Section
      ->where('curriculum_subject_id', $curriculumSubjectId)
      ->where('period_id', $periodId)
      ->whereNull('deleted_at')
      ->count();
  }





  /**
   * Create a new Section
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\Section $Section
   */
  public function create(array $data)
  {
    $section = new Section();
    $section->fill($data)->save();

    return $section;
  }

  /**
   * Update an existing Section
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\Section $Section
   *
   * @return boolean
   */
  public function update(array $data, $section = null)
  {
    if (empty($section)) {
      $section = $this->byId($data['id']);
    }

    return $section->update($data);
  }

  /**
   * Delete existing Section
   *
   * @param integer $id
   * 	An Section id
   *
   * @return boolean
   */
  public function delete($id, $section = null)
  {
    if (empty($section)) {
      $section = $this->byId($id);
    }

    return $section->delete();
  }
}
