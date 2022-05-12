<?php

/**
 * @file
 * EloquentSection
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Section;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Section;

class EloquentSection implements SectionInterface
{

  /**
   * Section
   *
   * @var App\Models\Section;
   *
   */
  protected $Section;

  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $Section, DB $DB)
  {
    $this->Section = $Section;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of Sections
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('sections AS s')
      ->select(
        's.code',
        's.quota',
        's.schedule',
        's.curriculum_subject_id',
        's.period_id',
        's.teacher_id',
        't.name',
        't.last_name'
      )
      ->join('teachers as t', 's.teacher_id', '=', 't.id');


    if (!empty($filter)) {
      $query->where(function ($dbQuery) use ($filter) {
        foreach (['name', 'email'] as $key => $value) {
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
    return $this->Section->find($id);
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
  public function delete($id)
  {
    return $this->Section->destroy($id);
  }
}
