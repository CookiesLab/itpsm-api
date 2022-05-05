<?php

/**
 * @file
 * EloquentCareer
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Career;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Career;

class EloquentCareer implements CareerInterface
{

  /**
   * Career
   *
   * @var App\Models\Career;
   *
   */
  protected $Career;

  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $Career, DB $DB)
  {
    $this->Career = $Career;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of Careers
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('careers AS c')
      ->select(
        'c.id',
        'c.name'
      )


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
   * Get an Career by id
   *
   * @param  int $id
   *
   * @return App\Models\Career
   */
  public function byId($id)
  {
    return $this->Career->find($id);
  }

  /**
   * Create a new Career
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\Career $Career
   */
  public function create(array $data)
  {
    $career = new Career();
    $career->fill($data)->save();

    return $career;
  }

  /**
   * Update an existing Career
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\Career $Career
   *
   * @return boolean
   */
  public function update(array $data, $career = null)
  {
    if (empty($career)) {
      $career = $this->byId($data['id']);
    }

    return $career->update($data);
  }

  /**
   * Delete existing Career
   *
   * @param integer $id
   * 	An Career id
   *
   * @return boolean
   */
  public function delete($id)
  {
    return $this->Career->destroy($id);
  }
}
