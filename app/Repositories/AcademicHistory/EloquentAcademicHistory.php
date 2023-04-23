<?php

/**
 * @file
 * EloquentAcademicHistory
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\AcademicHistory;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\AcademicHistory;
use App\Models\Enrollment;

class EloquentAcademicHistory implements AcademicHistoryInterface
{

  /**
   * AcademicHistory
   *
   * @var App\Models\AcademicHistory;
   *
   */
  protected $Curriculum;

    /**
   * Enrollment
   *
   * @var App\Models\Enrollment;
   *
   */
  protected $Enrollment;

  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $Curriculum, DB $DB)
  {
    $this->Curriculum = $Curriculum;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of Curricula
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('academic_history AS c')
      ->select(
        'c.id',
        'c.subject_id',
        'c.curriculum_id',
        'c.totalScore',
        'c.isEquivalence',
        'c.year',
        'c.period'
      );

    if (!empty($filter)) {
      $query->where(function ($dbQuery) use ($filter) {
        foreach (['c.name', 'c.year', 'ca.name'] as $key => $value) {
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
   * Get an Curriculum by id
   *
   * @param  int $id
   *
   * @return App\Models\AcademicHistory
   */
  public function byId($id)
  {
    // $query = $this->DB::table('enrollments as e')
    // ->join('subjects s2','s2.id', '=','e.curriculum_subject_id ');
    $query = $this->DB::table('enrollments as e')
      ->select(
        's2.name',
        'e.final_score',
        'e.is_approved',
        DB::raw("concat(t.name,' ',t.last_name) as teachername"),
        'e.enrollment'
      )
      ->join('sections as s','s.id', '=','e.code')
      ->join('teachers as t','t.id', '=','s.teacher_id')
      ->join('subjects as s2','s2.id', '=','e.curriculum_subject_id');
      
    

    return new Collection(
      $query->get()
    );
  }

  /**
   * Create a new AcademicHistory
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\AcademicHistory $AcademicHistory
   */
  public function create(array $data)
  {
    $AcademicHistory = new AcademicHistory();
    $AcademicHistory->fill($data)->save();

    return $AcademicHistory;
  }

  /**
   * Update an existing Curriculum
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\AcademicHistory $Curriculum
   *
   * @return boolean
   */
  public function update(array $data, $curriculum = null)
  {
    if (empty($curriculum)) {
      $curriculum = $this->byId($data['id']);
    }

    return $curriculum->update($data);
  }

  /**
   * Delete existing AcademicHistory
   *
   * @param integer $id
   * 	An Curriculum id
   *
   * @return boolean
   */
  public function delete($id)
  {
    return $this->Curriculum->destroy($id);
  }
}
