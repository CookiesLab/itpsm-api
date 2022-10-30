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
use Illuminate\Support\Facades\Log;

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
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null, $customQuery = null)
  {
    $query = $this->DB::table('enrollments AS e')
      ->select(
        'es.score',
        'e.student_id',
        'st.carnet','st.name','st.last_name',
        'ev.id'
      )->join('sections as s', 's.id', '=', 'e.code')
      ->join('students as st', 'st.id', '=', 'e.student_id')
      ->join('evaluations as ev', 's.id', '=', 'ev.section_id')
      ->leftjoin('score_evaluations as es', 'ev.id', '=', 'es.evaluation_id')
      ->whereRaw('es.student_id =st.id')
      ;


    if (!empty($filter)) {
      $query->where(function ($dbQuery) use ($filter) {
        foreach (['t.name', 't.last_name', 't.email', 't.nit', 't.dui', 't.nup_number', 't.isss_number'] as $key => $value) {
          $dbQuery->orWhere($value, 'like', '%' . str_replace(' ', '%', $filter) . '%');
          //$dbQuery->orwhereRaw('lower(`' . $value . '`) LIKE ? ',['%' . strtolower(str_replace(' ', '%', $filter)) . '%']);
        }
      });
    }
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
          if($statement['field'] == 'ev.id'){
            $dbQuery->where($statement['field'], $statement['op'], $statement['data']);
        
            continue;
          }
          $dbQuery->where($statement['field'], $statement['op'], $statement['data']);
         
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
    Log::emergency($query->toSql());
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
   
    //$ids = get_keys_data($id);

    return $this->ScoreEvaluation
      ->where('student_id', intval($id['student_id']))
      ->where('evaluation_id', intval($id['evaluation_id']))
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
    if (!empty($scoreEvaluation)) {
    
      $scoreEvaluation->update(['score' => $data['score']]);;
    }

    return $scoreEvaluation;
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
  public function clean($id)
  {
    $scores=$this->ScoreEvaluation
     
      ->where('evaluation_id', intval($id))
      ->get();
    
      foreach ($scores as $score) {
   
        $score->delete();
      }


  }
   
  public function insert_students_to_evaluations($students,$id)
  {

    foreach ($students as $student) {
   
      $this->ScoreEvaluation->insert([
        'score' => null,
        'student_id' => $student->student_id,
        'evaluation_id' => $id,
        'created_at' => now(),
    ]);
    }
   
  }
}
