<?php

/**
 * @file
 * Curriculum Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\AcademicHistory;

use App\Repositories\AcademicHistory\AcademicHistoryInterface;
use Carbon\Carbon;

class AcademicHistoryManager
{
  /**
   * Curriculum
   *
   * @var App\Repositories\AcademicHistory\AcademicHistoryInterface;
   *AcademicHistory
   */
  protected $academicHistory;

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
    AcademicHistoryInterface $academicHistory,
    Carbon $Carbon
  ) {
    $this->academicHistory = $academicHistory;
    $this->Carbon = $Carbon;
    $this->responseType = 'academic_history';
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
      $count = $this->academicHistory->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->academicHistory->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder)->each(function ($academicHistory) use (&$rows) {

      $id = strval($academicHistory->id);
      unset($academicHistory->id);

      array_push($rows, [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $academicHistory
      ]);
    });

    return [
      'rows' => $rows,
      'page' => $page,
      'totalPages' => $totalPages,
      'records' => $count,
    ];
  }

  public function getCurriculum($id)
  {
    return $this->academicHistory->byId($id);
  }

  public function create($request)
  {
      $academicHistory = $this->academicHistory->create($request->all());
    $id = strval($academicHistory->id);
    unset($academicHistory->id);

    return [
      'success' => true,
      'curriculum' => $academicHistory,
      'id' => $id,
    ];
  }

  public function update($request, $id)
  {
      $academicHistory = $this->academicHistory->byId($id);

    if (empty($academicHistory)) {
      return [
        'success' => false,
      ];
    }

    $this->academicHistory->update($request->all(), $academicHistory);
      $academicHistory = $this->academicHistory->byId($id);
    unset($academicHistory->id);

    return [
      'success' => true,
      'curriculum' => $academicHistory,
      'id' => $id,
    ];

  }

  public function delete($id)
  {
      $academicHistory = $this->academicHistory->byId($id);

    if (empty($academicHistory)) {
      return false;
    }

    $this->academicHistory->delete($id);

    return true;
  }
}
