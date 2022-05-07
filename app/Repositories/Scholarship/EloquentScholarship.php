<?php

/**
 * @file
 * EloquentScholarship
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Scholarship;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Scholarship;

class EloquentScholarship implements ScholarshipInterface
{

  /**
   * Scholarship
   *
   * @var App\Models\Scholarship;
   *
   */
  protected $Scholarship;

  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $Scholarship, DB $DB)
  {
    $this->Scholarship = $Scholarship;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of Scholarships
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('scholarships AS s')
      ->select(
        's.id',
        's.name',
        's.scholarship_foundation'
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
   * Get an Scholarship by id
   *
   * @param  int $id
   *
   * @return App\Models\Scholarship
   */
  public function byId($id)
  {
    return $this->Scholarship->find($id);
  }

  /**
   * Create a new Scholarship
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\Scholarship $Scholarship
   */
  public function create(array $data)
  {
    $scholarship = new Scholarship();
    $scholarship->fill($data)->save();

    return $scholarship;
  }

  /**
   * Update an existing Scholarship
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\Scholarship $Scholarship
   *
   * @return boolean
   */
  public function update(array $data, $scholarship = null)
  {
    if (empty($scholarship)) {
      $scholarship = $this->byId($data['id']);
    }

    return $scholarship->update($data);
  }

  /**
   * Delete existing Scholarship
   *
   * @param integer $id
   * 	An Scholarship id
   *
   * @return boolean
   */
  public function delete($id)
  {
    return $this->Scholarship->destroy($id);
  }
}
