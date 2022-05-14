<?php

/**
 * @file
 * ScoreEvaluation Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\ScoreEvaluation;

use App\Repositories\ScoreEvaluation\ScoreEvaluationInterface;
use Carbon\Carbon;

class ScoreEvaluationManager
{
  /**
   * ScoreEvaluation
   *
   * @var App\Repositories\ScoreEvaluation\ScoreEvaluationInterface;
   *
   */
  protected $ScoreEvaluation;

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
    ScoreEvaluationInterface $ScoreEvaluation,
    Carbon $Carbon
  ) {
    $this->ScoreEvaluation = $ScoreEvaluation;
    $this->Carbon = $Carbon;
    $this->responseType = 'scoreEvaluations';
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
    // else
    // {
    //   $sortColumn = 'id';
    //   $sortOrder = 'desc';
    // }

    if ($pager)
    {
      $count = $this->ScoreEvaluation->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->ScoreEvaluation->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder)->each(function ($scoreEvaluation) use (&$rows) {

    //   $id = strval($scoreEvaluation->id);
    //   unset($scoreEvaluation->id);

      array_push($rows, [
        'type' => $this->responseType,
        // 'id' => $id,
        'attributes' => $scoreEvaluation
      ]);
    });

    return [
      'rows' => $rows,
      'page' => $page,
      'totalPages' => $totalPages,
      'records' => $count,
    ];
  }

  public function getScoreEvaluation($id)
  {
    return $this->ScoreEvaluation->byId($id);
  }

  public function create($request)
  {
    $scoreEvaluation = $this->ScoreEvaluation->create($request->all());
    $id = strval($scoreEvaluation->id);
    unset($scoreEvaluation->id);

    return [
      'success' => true,
      'scoreEvaluation' => $scoreEvaluation,
      'id' => $id,
    ];
  }

  public function update($request, $id)
  {
    $scoreEvaluation = $this->ScoreEvaluation->byId($id);

    if (empty($scoreEvaluation)) {
      return [
        'success' => false,
      ];
    }

    $this->ScoreEvaluation->update($request->all(), $scoreEvaluation);
    $scoreEvaluation = $this->ScoreEvaluation->byId($id);
    unset($scoreEvaluation->id);

    return [
      'success' => true,
      'scoreEvaluation' => $scoreEvaluation,
      'id' => $id,
    ];

  }

  public function delete($id)
  {
    $ScoreEvaluation = $this->ScoreEvaluation->byId($id);

    if (empty($ScoreEvaluation)) {
      return false;
    }

    $this->ScoreEvaluation->delete($id);

    return true;
  }
}
