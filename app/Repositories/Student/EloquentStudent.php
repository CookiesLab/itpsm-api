<?php

/**
 * @file
 * EloquentStudent
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Student;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Student;

class EloquentStudent implements StudentInterface
{

  /**
   * Student
   *
   * @var App\Models\Student;
   *
   */
  protected $Student;

  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $Student, DB $DB)
  {
    $this->Student = $Student;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of Students
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('students AS s')
      ->select(
        's.id',
        's.carnet',
        's.name',
        's.last_name',
        's.birth_date',
        's.email',
        's.address',
        's.phone_number',
        's.home_phone_number',
        's.gender',
        's.relationship',
        's.status',
        's.blood_type',
        's.mother_name',
        's.mother_phone_number',
        's.father_name',
        's.father_phone_number',
        's.emergency_contact_name',
        's.emergency_contact_phone',
        's.diseases',
        's.allergies',
        's.date_high_school_degree',
        'm.id AS municipality_id',
        'm.name AS municipality',
        'd.id AS department_id',
        'd.name AS department',
        'c.id AS country_id',
        'c.name AS country',
      )
      ->join('municipalities as m', 's.municipality_id', '=', 'm.id')
      ->join('departments as d', 's.department_id', '=', 'd.id')
      ->join('countries as c', 's.country_id', '=', 'c.id')
      ->whereNull('s.deleted_at');
      // ->join('users', 'articles.user_id', '=', 'user.id')


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
   * Get an Student by id
   *
   * @param  int $id
   *
   * @return App\Models\Student
   */
  public function byId($id)
  {
    return $this->Student->find($id);
  }

  /**
   * Create a new Student
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\Student $Student
   */
  public function create(array $data)
  {
    $student = new Student();
    $student->fill($data)->save();

    return $student;
  }

  /**
   * Update an existing Student
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\Student $Student
   *
   * @return boolean
   */
  public function update(array $data, $student = null)
  {
    if (empty($student)) {
      $student = $this->byId($data['id']);
    }

    return $student->update($data);
  }

  /**
   * Delete existing Student
   *
   * @param integer $id
   * 	An Student id
   *
   * @return boolean
   */
  public function delete($id)
  {
    return $this->Student->destroy($id);
  }
}
