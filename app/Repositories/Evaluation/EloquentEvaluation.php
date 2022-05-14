<?php

/**
 * @file
 * EloquentEvaluation
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Evaluation;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Evaluation;

class EloquentEvaluation implements EvaluationInterface
{

  /**
   * Evaluation
   *
   * @var App\Models\Evaluation;
   *
   */
  protected $Evaluation;

  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $Evaluation, DB $DB)
  {
    $this->Evaluation = $Evaluation;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of Evaluations
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('evaluations AS e')
      ->select(
        'e.id',
        'e.name',
        'e.description',
        'e.date',
        'e.percentage',
        'e.section_id'
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
   * Get an Evaluation by id
   *
   * @param  int $id
   *
   * @return App\Models\Evaluation
   */
  public function byId($id)
  {
    return $this->Evaluation->find($id);
  }

  /**
   * Create a new Evaluation
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\Evaluation $Evaluation
   */
  public function create(array $data)
  {
    $evaluation = new Evaluation();
    $evaluation->fill($data)->save();

    return $evaluation;
  }

  /**
   * Update an existing Evaluation
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\Evaluation $Evaluation
   *
   * @return boolean
   */
  public function update(array $data, $evaluation = null)
  {
    if (empty($evaluation)) {
      $evaluation = $this->byId($data['id']);
    }

    return $evaluation->update($data);
  }

  /**
   * Delete existing Evaluation
   *
   * @param integer $id
   * 	An Evaluation id
   *
   * @return boolean
   */
  public function delete($id)
  {
    return $this->Evaluation->destroy($id);
  }
}
