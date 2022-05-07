<?php

/**
 * @file
 * EloquentStudentCurricula
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\StudentCurricula;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\StudentCurricula;

class EloquentStudentCurricula implements StudentCurriculaInterface
{

  /**
   * StudentCurricula
   *
   * @var App\Models\StudentCurricula;
   *
   */
  protected $StudentCurricula;

  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $StudentCurricula, DB $DB)
  {
    $this->StudentCurricula = $StudentCurricula;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of StudentCurriculas
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('student_curricula AS sc')
      ->select(
        'sc.cum',
        'sc.entry_year',
        'sc.graduation_year',
        'sc.scholarship_rate',
        's.id AS scholarship_id',
        's.name AS scholarship_name',
        's.scholarship_foundation AS scholarship_foundation',
        'c.id AS curricula_id',
        'c.name AS curricula_name',
        'c.year AS curricula_year',
        'c.is_active AS curricula_is_active',
        'st.id AS student_id',
        'st.name AS student_name',
        'st.last_name AS student_last_name',
        'st.carnet AS student_carnet' 
      )
      ->join('scholarships as s', 'sc.scholarship_id', '=', 's.id')
      ->join('curricula as c', 'sc.curriculum_id', '=', 'c.id')
      ->join('students as st', 'sc.student_id', '=', 'st.id');


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
   * Get an StudentCurricula by id
   *
   * @param  int $id
   *
   * @return App\Models\StudentCurricula
   */
  public function byId($id)
  {
    return $this->StudentCurricula->find($id);
  }

  /**
   * Create a new StudentCurricula
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\StudentCurricula $StudentCurricula
   */
  public function create(array $data)
  {
    $studentCurricula = new StudentCurricula();
    $studentCurricula->fill($data)->save();

    return $studentCurricula;
  }

  /**
   * Update an existing StudentCurricula
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\StudentCurricula $StudentCurricula
   *
   * @return boolean
   */
  public function update(array $data, $studentCurricula = null)
  {
    if (empty($studentCurricula)) {
      $studentCurricula = $this->byId($data['id']);
    }

    return $studentCurricula->update($data);
  }

  /**
   * Delete existing StudentCurricula
   *
   * @param integer $id
   * 	An StudentCurricula id
   *
   * @return boolean
   */
  public function delete($id)
  {
    return $this->StudentCurricula->destroy($id);
  }
}
