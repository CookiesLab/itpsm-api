<?php

/**
 * @file
 * Evaluation Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\Comments;

use App\Repositories\Comments\CommentsInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CommentsManager
{
  /**
   * Evaluation
   *
   * @var App\Repositories\Evaluation\EvaluationInterface;
   *
   */
  protected $Comments;

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
    CommentsInterface $Evaluation,
    Carbon $Carbon
  ) {
    $this->Comments = $Evaluation;
    $this->Carbon = $Carbon;
    $this->responseType = 'comments';
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

  public function getcomment($id)
  {
    return $this->Comments->byId($id);
  }

  public function create($request)
  {
    $comment = $this->Comments->create($request->all());
    $id = strval($comment->id);
    unset($comment->id);

    return [
      'success' => true,
      'evaluation' => $comment,
      'id' => $comment->id,
    ];
  }

  public function update($request, $id)
  {
    $evaluation = $this->Comments->byId($id);

    if (empty($evaluation)) {
      return [
        'success' => false,
      ];
    }

    $this->Comments->update($request->all(), $evaluation);
    $evaluation = $this->Comments->byId($id);
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

  public function publish($id)
  {


    $this->Evaluation->publish($id);


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
