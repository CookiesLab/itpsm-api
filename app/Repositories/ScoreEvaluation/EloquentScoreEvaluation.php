<?php

/**
 * @file
 * EloquentScoreEvaluation
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\ScoreEvaluation;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\ScoreEvaluation;

class EloquentScoreEvaluation implements ScoreEvaluationInterface
{

  /**
   * ScoreEvaluation
   *
   * @var App\Models\ScoreEvaluation;
   *
   */
  protected $ScoreEvaluation;

  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $ScoreEvaluation, DB $DB)
  {
    $this->ScoreEvaluation = $ScoreEvaluation;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of ScoreEvaluations
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('score_evaluations AS se')
      ->select(
        'se.score',
        'se.student_id',
        'se.evaluation_id'
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
   * Get an ScoreEvaluation by id
   *
   * @param  int $id
   *
   * @return App\Models\ScoreEvaluation
   */
  public function byId($id)
  {
    $ids = get_keys_data($id);

    return $this->StudentCurriculum
      ->where('student_id', intval($ids[0]))
      ->where('evaluation_id', intval($ids[1]))
      ->first();
  }

  /**
   * Create a new ScoreEvaluation
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\ScoreEvaluation $ScoreEvaluation
   */
  public function create(array $data)
  {
    $scoreEvaluation = new ScoreEvaluation();
    $scoreEvaluation->fill($data)->save();

    return $scoreEvaluation;
  }

  /**
   * Update an existing ScoreEvaluation
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\ScoreEvaluation $ScoreEvaluation
   *
   * @return boolean
   */
  public function update(array $data, $scoreEvaluation = null)
  {
    if (empty($scoreEvaluation)) {
      $scoreEvaluation = $this->byId($data['id']);
    }

    return $scoreEvaluation->update($data);
  }

  /**
   * Delete existing ScoreEvaluation
   *
   * @param integer $id
   * 	An ScoreEvaluation id
   *
   * @return boolean
   */
  public function delete($id, $scoreEvaluation = null)
  {
    if (empty($scoreEvaluation)) {
      $scoreEvaluation = $this->byId($id);
    }

    return $scoreEvaluation->delete();
  }
}
