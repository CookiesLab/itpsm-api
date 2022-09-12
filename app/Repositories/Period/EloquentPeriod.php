<?php

/**
 * @file
 * EloquentPeriod
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Period;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Period;

class EloquentPeriod implements PeriodInterface
{

  /**
   * Period
   *
   * @var App\Models\Period;
   *
   */
  protected $Period;

  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $Period, DB $DB)
  {
    $this->Period = $Period;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of Periods
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('periods AS p')
      ->select(
        'p.id',
        'p.code',
        'p.year',
        'p.status'
      );


    if (!empty($filter)) {
      $query->where(function ($dbQuery) use ($filter) {
        foreach (['p.code', 'p.year', 'p.status'] as $key => $value) {
          $dbQuery->orWhere($value, 'like', '%' . str_replace(' ', '%', $filter) . '%');
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

  public function getActiveToBeEnrolled()
  {
    return $this->Period
      ->where('status', '=', 'I')
      ->where('year', '=', date('Y'))
      ->first();
  }


  /**
   * Get an Period by id
   *
   * @param  int $id
   *
   * @return App\Models\Period
   */
  public function byId($id)
  {
    return $this->Period->find($id);
  }

  /**
   * Create a new Period
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\Period $Period
   */
  public function create(array $data)
  {
    $period = new Period();
    $period->fill($data)->save();

    return $period;
  }

  /**
   * Update an existing Period
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\Period $Period
   *
   * @return boolean
   */
  public function update(array $data, $period = null)
  {
    if (empty($period)) {
      $period = $this->byId($data['id']);
    }

    return $period->update($data);
  }

  /**
   * Delete existing Period
   *
   * @param integer $id
   * 	An Period id
   *
   * @return boolean
   */
  public function delete($id)
  {
    return $this->Period->destroy($id);
  }
}
