<?php

/**
 * @file
 * EloquentMunicipality
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Municipality;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Municipality;

class EloquentMunicipality implements MunicipalityInterface
{

  /**
   * Municipality
   *
   * @var App\Models\Municipality;
   *
   */
  protected $Municipality;

  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $Municipality, DB $DB)
  {
    $this->Municipality = $Municipality;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of Municipalitys
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('municipalities AS m')
      ->select(
        'm.id',
        'm.name',
        'm.country_id',
        'm.department_id'
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
   * Get an Municipality by id
   *
   * @param  int $id
   *
   * @return App\Models\Municipality
   */
  public function byId($id)
  {
    return $this->Municipality->find($id);
  }

  /**
   * Get an Municipalities by departmentId
   *
   * @param  int $id
   *
   * @return App\Models\Collection
   */
  public function getMunicipalitiesByDepartmentId($id)
  {
    return $this->Municipality
    ->where('department_id', '=', $id)
    ->get();
  }

  /**
   * Create a new Municipality
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\Municipality $Municipality
   */
  public function create(array $data)
  {
    $municipality = new Municipality();
    $municipality->fill($data)->save();

    return $municipality;
  }

  /**
   * Update an existing Municipality
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\Municipality $Municipality
   *
   * @return boolean
   */
  public function update(array $data, $municipality = null)
  {
    if (empty($municipality)) {
      $municipality = $this->byId($data['id']);
    }

    return $municipality->update($data);
  }

  /**
   * Delete existing Municipality
   *
   * @param integer $id
   * 	An Municipality id
   *
   * @return boolean
   */
  public function delete($id)
  {
    return $this->Municipality->destroy($id);
  }
}
