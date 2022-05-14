<?php

/**
 * @file
 * EloquentCountry
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Country;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Country;

class EloquentCountry implements CountryInterface
{

  /**
   * Country
   *
   * @var App\Models\Country;
   *
   */
  protected $Country;

  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $Country, DB $DB)
  {
    $this->Country = $Country;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of Countries
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('countries AS c')
      ->select(
        'c.id',
        'c.name'
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
   * Get an Country by id
   *
   * @param  int $id
   *
   * @return App\Models\Country
   */
  public function byId($id)
  {
    return $this->Country->find($id);
  }

  /**
   * Create a new Country
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\Country $Country
   */
  public function create(array $data)
  {
    $country = new Country();
    $country->fill($data)->save();

    return $country;
  }

  /**
   * Update an existing Country
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\Country $Country
   *
   * @return boolean
   */
  public function update(array $data, $country = null)
  {
    if (empty($country)) {
      $country = $this->byId($data['id']);
    }

    return $country->update($data);
  }

  /**
   * Delete existing Country
   *
   * @param integer $id
   * 	An Country id
   *
   * @return boolean
   */
  public function delete($id)
  {
    return $this->Country->destroy($id);
  }
}
