<?php

/**
 * @file
 * EloquentSubject
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Subject;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Subject;

class EloquentSubject implements SubjectInterface
{

  /**
   * Subject
   *
   * @var App\Models\Subject;
   *
   */
  protected $Subject;

  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $Subject, DB $DB)
  {
    $this->Subject = $Subject;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of Subjects
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('subjects AS s')
      ->select(
        's.id',
        's.name',
        's.code'
      );


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
   * Get an Subject by id
   *
   * @param  int $id
   *
   * @return App\Models\Subject
   */
  public function byId($id)
  {
    return $this->Subject->find($id);
  }

  /**
   * Create a new Subject
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\Subject $Subject
   */
  public function create(array $data)
  {
    $subject = new Subject();
    $subject->fill($data)->save();

    return $subject;
  }

  /**
   * Update an existing Subject
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\Subject $Subject
   *
   * @return boolean
   */
  public function update(array $data, $subject = null)
  {
    if (empty($subject)) {
      $subject = $this->byId($data['id']);
    }

    return $subject->update($data);
  }

  /**
   * Delete existing Subject
   *
   * @param integer $id
   * 	An Subject id
   *
   * @return boolean
   */
  public function delete($id)
  {
    return $this->Subject->destroy($id);
  }
}
