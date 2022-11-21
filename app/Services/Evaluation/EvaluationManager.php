<?php

/**
 * @file
 * Evaluation Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\Evaluation;

use App\Repositories\Evaluation\EvaluationInterface;
use App\Repositories\Enrollment\EnrollmentInterface;
use App\Repositories\ScoreEvaluation\ScoreEvaluationInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EvaluationManager
{
  /**
   * Evaluation
   *
   * @var App\Repositories\Evaluation\EvaluationInterface;
   *
   */
  protected $Evaluation;
  /**
   * Score_Evaluation
   *
   * @var App\Repositories\ScoreEvaluation\ScoreEvaluationInterface;
   *
   */
  protected $Score_Evaluation;
    /**
   * Enrollment
   *
   * @var App\Repositories\Enrollment\EnrollmentInterface;
   *
   */
  protected $Enrollment;
  /**
   * Carbon instance
   *
   * @var Carbon\Carbon
   *
   */
  protected $Carbon;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    EnrollmentInterface $Enrollment,
    ScoreEvaluationInterface $Score_Evaluation,
    EvaluationInterface $Evaluation,
    Carbon $Carbon
  ) {
    $this->Enrollment = $Enrollment;
    $this->Score_Evaluation = $Score_Evaluation;
    $this->Evaluation = $Evaluation;
    $this->Carbon = $Carbon;
    $this->responseType = 'evaluations';
  }

  public function getTableRowsWithPagination($request, $pager = true, $returnJson = true)
  {
    $rows = [];
    $limit = $offset = $count = $page = $totalPages = 0;
    $filter = $sortColumn = $sortOrder=$customQuery = '';

    if (!empty($request['filter']))
    {
      $filter = $request['filter'];
    }
    if (!empty($request['query']))
    {
      $customQuery = json_decode($request['query'], true)['query'];
    }

    if (!empty($request['sort']) && $request['sort'][0] == '-')
    {
      $sortColumn = substr($request['sort'], 1);
      $sortOrder = 'desc';
    }
    else if (!empty($request['sort']))
    {
      $sortColumn = $request['sort'];
      $sortOrder = 'asc';
    }
    else
    {
      $sortColumn = 'id';
      $sortOrder = 'desc';
    }

    if ($pager)
    {
      $count = $this->Evaluation->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder,$customQuery);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->Evaluation->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder,$customQuery)->each(function ($evaluation) use (&$rows) {

      $id = strval($evaluation->id);
      unset($evaluation->id);

      array_push($rows, [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $evaluation
      ]);
    });

    return [
      'rows' => $rows,
      'page' => $page,
      'totalPages' => $totalPages,
      'records' => $count,
    ];
  }

  public function getEvaluation($id)
  {
    return $this->Evaluation->byId($id);
  }
  public function getEvaluations_section($section_id,$principal)
  {
    return $this->Evaluation->get_Evals($section_id,$principal);
  }
  public function create($request)
  {
    $evaluation = $this->Evaluation->create($request->all());
    if (empty($evaluation)) {
      return [
        'success' => false,
      ];
    }
    $id = strval($evaluation->id);
    unset($evaluation->id);

    return [
      'success' => true,
      'evaluation' => $evaluation,
      'id' => $id,
    ];
  }

  public function update($request, $id)
  {
    $evaluation = $this->Evaluation->byId($id);

    if (empty($evaluation)) {
      return [
        'success' => false,
      ];
    }

    $this->Evaluation->update($request->all(), $evaluation);
    $evaluation = $this->Evaluation->byId($id);
    unset($evaluation->id);

    return [
      'success' => true,
      'evaluation' => $evaluation,
      'id' => $id,
    ];

  }

  public function delete($id)
  {
    $Evaluation = $this->Evaluation->byId($id);

    if (empty($Evaluation)) {
      return false;
    }
    $this->Score_Evaluation->clean($id);
    $this->Evaluation->delete($id);


    return true;
  }

  public function publish($id)
  {


    $this->Evaluation->publish($id);


    return [
      'success' => true,

    ];

  }
  public function aprobacion($id,$status)
  {


    $this->Evaluation->aprobacion($id,$status);


    $evaluations=$this->Evaluation->publish($id);


    foreach ($evaluations as $evaluation) {

      $students=$this->Enrollment->getStudents($evaluation->section_id);

      $this->Score_Evaluation->insert_students_to_evaluations($students,$evaluation->id);
    }
    return [
      'success' => true,

    ];

  }
  public function publishgrades($id)
  {


    $this->Evaluation->publishgrades($id);


    return [
      'success' => true,

    ];

  }
  public function uploadgrades($id)
  {


    $this->Evaluation->uploadgrades($id);


    return [
      'success' => true,

    ];

  }
  public function getEvaluations($id)
  {
    $Evaluation = $this->Evaluation->byperiodId($id);

    if (empty($Evaluation)) {
      return [
        'success' => false,

      ];
    }
    $rows = [];

    $Evaluation->each(function ($evaluation) use (&$rows) {

      if($evaluation->status!=1){
        unset($evaluation->score);
      }
      $id = strval($evaluation->id);


      array_push($rows, $evaluation);
    });

    return [
      'success' => true,
      'evaluation' => $rows,
      'id' => $id,
    ];
  }
}
