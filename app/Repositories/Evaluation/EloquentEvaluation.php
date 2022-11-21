<?php

/**
 * @file
 * EloquentEvaluation
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Evaluation;
use Illuminate\Support\Facades\Log;
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
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null, $customQuery = null)
  {
    $query = $this->DB::table('evaluations AS e')
      ->select(
        'e.id',
        'e.name',
        'e.description',
        'e.date',
        'e.percentage',
        'e.section_id',
        'e.is_public',
        'e.status',
        's.code',
        'sj.name as materia',
        'e.is_approved'
      )->join('sections as s', 's.id', '=', 'e.section_id')
      ->join('curriculum_subjects as cs', 'cs.id', '=', 's.curriculum_subject_id')
      ->join('subjects as sj', 'sj.id', '=', 'cs.subject_id');
      //->where('s.teacher_id', '=', auth()->user()->system_reference_id);

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
            if($statement['field'] == 's.id'){
              $dbQuery->where($statement['field'], $statement['op'], $statement['data']);
              continue;
            }
            $dbQuery->where($statement['field'], $statement['op'], $statement['data']);

          }
        });
      }

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
   * Get an Evaluation by id
   *
   * @param  int $id
   *
   * @return App\Models\Evaluation
   */
  public function byperiodId($id)
  {
    $query = $this->DB::table('evaluations AS e')
      ->select(
        'e.id',
        'e.name',
        'e.description',
        'e.date',
        'e.percentage',
        'e.section_id',
        'e.is_public',
        'e.status',
        'sc.score',
        'e.is_approved'
      )->join('sections as s', 's.id', '=', 'e.section_id')
      ->join('enrollments as r', 'r.code', '=', 'e.section_id')
      ->join('students as st', 'st.id', '=', 'r.student_id')
      ->leftjoin('score_evaluations as sc', 'sc.evaluation_id', '=', 'e.id')
      ->whereRaw('sc.student_id =st.id')
      ->where('r.student_id', '=', auth()->user()->system_reference_id)
      ->where('e.is_public', '=', '1');

      return new Collection(
        $query->get()
      );
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
    Log::emergency($data);
    $porcentaje=$this->Evaluation->where('section_id','=', $data['section_id'])->sum('percentage');
    if($porcentaje+$data['percentage']>100){
      return null;
    }
   
    $evaluation = new Evaluation();
    $evaluation->fill($data)->save();

    return $evaluation;
  }

  /**
   * Get the principal evaluations
   *
   * @param integer $section_id
   *
   *
   * @return App\Models\Evaluation $Evaluation
   */
  public function get_Evals($section_id,$principal)
  {
    $query = $this->DB::table('evaluations AS e')
      ->where('e.section_id', '=', $section_id)
      ->where('e.principal_id', '=', $principal);

    return new Collection(
      $query->get()
    );
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
  /**
   * Update status of Evaluation
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\Evaluation $Evaluation
   *
   * @return boolean
   */
  public function publish($id)
  {
    //$this->Evaluation->where('section_id','=', $id)->where('is_public','=', 0)->update(['is_public' => 1]);
    $evaluations=$this->Evaluation->where('section_id','=', $id)->where('is_public','=', 0)->get();

    foreach ($evaluations as $evaluation) {
    
      $evaluation->is_public=1;
      $evaluation->save();

    }
    //$this->Evaluation->where('section_id','=', $id)->where('is_public','=', 0)->delete();
    //$this->Evaluation->where('section_id', $id)->destroy();
  }
  public function aprobacion($id,$status)
  {
    //$this->Evaluation->where('section_id','=', $id)->where('is_public','=', 0)->update(['is_public' => 1]);
    $evaluations=$this->Evaluation->where('section_id','=', $id)->get();

    foreach ($evaluations as $evaluation) {
      Log::emergency($evaluation);
      $evaluation->is_approved=$status;
      $evaluation->save();

    }
    return $evaluations;
    //$this->Evaluation->where('section_id','=', $id)->where('is_public','=', 0)->delete();
    //$this->Evaluation->where('section_id', $id)->destroy();
  }
  public function publishgrades($id)
  {

    $evaluations=$this->Evaluation->where('id','=', $id)->get();

    foreach ($evaluations as $evaluation) {
      Log::emergency($evaluation);
      $evaluation->status=1;
      $evaluation->save();

    }
    //$this->Evaluation->where('section_id','=', $id)->where('is_public','=', 0)->delete();
    //$this->Evaluation->where('section_id', $id)->destroy();
  }
  public function uploadgrades($id)
  {
    //$this->Evaluation->where('section_id','=', $id)->where('is_public','=', 0)->update(['is_public' => 1]);
    $evaluations=$this->Evaluation->where('id','=', $id)->get();

    foreach ($evaluations as $evaluation) {
   
      $evaluation->status=0;
      $evaluation->save();

    }
    //$this->Evaluation->where('section_id','=', $id)->where('is_public','=', 0)->delete();
    //$this->Evaluation->where('section_id', $id)->destroy();
  }



}
