<?php

/**
 * @file
 * EloquentEnrollment
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Enrollment;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Enrollment;

class EloquentEnrollment implements EnrollmentInterface
{

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

  public function __construct(Model $Enrollment, DB $DB)
  {
    $this->Enrollment = $Enrollment;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of Enrollments
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('enrollments AS e')
      ->select(
        'e.final_score',
        'e.is_approved',
        'e.enrollment',
        'e.curriculum_subject_id',
        'e.period_id',
        'e.code',
        'e.student_id',
        'e.teacher_id'
      );


    if (!empty($filter)) {
      $query->where(function ($dbQuery) use ($filter) {
        foreach (['t.name', 't.last_name', 't.email', 't.nit', 't.dui', 't.nup_number', 't.isss_number'] as $key => $value) {
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
   * Get an Enrollment by id
   *
   * @param  int $id
   *
   * @return App\Models\Enrollment
   */
  public function byId($id)
  {
    return $this->Enrollment->find($id);
  }

  /**
   * Create a new Enrollment
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\Enrollment $Enrollment
   */
  public function create(array $data)
  {
    $enrollment = new Enrollment();
    $enrollment->fill($data)->save();

    return $enrollment;
  }

  /**
   * Update an existing Enrollment
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\Enrollment $Enrollment
   *
   * @return boolean
   */
  public function update(array $data, $enrollment = null)
  {
    if (empty($enrollment)) {
      $enrollment = $this->byId($data['id']);
    }

    return $enrollment->update($data);
  }

  /**
   * Delete existing Enrollment
   *
   * @param integer $id
   * 	An Enrollment id
   *
   * @return boolean
   */
  public function delete($id)
  {
    return $this->Enrollment->destroy($id);
  }
}
