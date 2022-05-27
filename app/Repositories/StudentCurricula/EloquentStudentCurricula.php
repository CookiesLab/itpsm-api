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
use App\Models\StudentCurriculum;

class EloquentStudentCurricula implements StudentCurriculaInterface
{

  /**
   * StudentCurriculum
   *
   * @var App\Models\StudentCurriculum;
   *
   */
  protected $StudentCurriculum;

  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $StudentCurriculum, DB $DB)
  {
    $this->StudentCurriculum = $StudentCurriculum;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of StudentCurricula
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null, $customQuery = null)
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
      ->leftJoin('scholarships as s', 'sc.scholarship_id', '=', 's.id')
      ->join('curricula as c', 'sc.curriculum_id', '=', 'c.id')
      ->join('students as st', 'sc.student_id', '=', 'st.id');

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
   * Get an StudentCurriculum by id
   *
   * @param  int $id
   *
   * @return App\Models\StudentCurriculum
   */
  public function byId($id)
  {
    $ids = get_keys_data($id);

    return $this->StudentCurriculum
      ->where('student_id', intval($ids[0]))
      ->where('curriculum_id', intval($ids[1]))
      ->first();
  }

  /**
   * Create a new StudentCurriculum
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\StudentCurriculum $StudentCurriculum
   */
  public function create(array $data)
  {
    $studentCurricula = new StudentCurriculum();
    $studentCurricula->fill($data)->save();

    return $studentCurricula;
  }

  /**
   * Update an existing StudentCurriculum
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\StudentCurriculum $StudentCurriculum
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
   * Delete existing StudentCurriculum
   *
   * @param integer $id
   * 	An StudentCurriculum id
   *
   * @return boolean
   */
  public function delete($id, $studentCurricula = null)
  {
    if (empty($studentCurricula)) {
      $studentCurricula = $this->byId($id);
    }

    return $studentCurricula->delete();
  }
}
