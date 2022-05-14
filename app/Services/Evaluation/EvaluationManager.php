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
use Carbon\Carbon;

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
    EvaluationInterface $Evaluation,
    Carbon $Carbon
  ) {
    $this->Evaluation = $Evaluation;
    $this->Carbon = $Carbon;
    $this->responseType = 'evaluations';
  }

  public function getTableRowsWithPagination($request, $pager = true, $returnJson = true)
  {
    $rows = [];
    $limit = $offset = $count = $page = $totalPages = 0;
    $filter = $sortColumn = $sortOrder = '';

    if (!empty($request['filter']))
    {
      $filter = $request['filter'];
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
      $count = $this->Evaluation->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->Evaluation->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder)->each(function ($evaluation) use (&$rows) {

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

  public function create($request)
  {
    $evaluation = $this->Evaluation->create($request->all());
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

    $this->Evaluation->delete($id);

    return true;
  }
}
