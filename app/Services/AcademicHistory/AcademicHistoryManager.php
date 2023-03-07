<?php

/**
 * @file
 * Curriculum Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\Curriculum;

use App\Repositories\Curriculum\CurriculumInterface;
use Carbon\Carbon;

class CurriculumManager
{
  /**
   * Curriculum
   *
   * @var App\Repositories\Curriculum\CurriculumInterface;
   *
   */
  protected $Curriculum;

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
    CurriculumInterface $Curriculum,
    Carbon $Carbon
  ) {
    $this->Curriculum = $Curriculum;
    $this->Carbon = $Carbon;
    $this->responseType = 'curricula';
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
      $count = $this->Curriculum->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->Curriculum->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder)->each(function ($curriculum) use (&$rows) {

      $id = strval($curriculum->id);
      unset($curriculum->id);

      array_push($rows, [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $curriculum
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
    return $this->Curriculum->byId($id);
  }

  public function create($request)
  {
    $curriculum = $this->Curriculum->create($request->all());
    $id = strval($curriculum->id);
    unset($curriculum->id);

    return [
      'success' => true,
      'curriculum' => $curriculum,
      'id' => $id,
    ];
  }

  public function update($request, $id)
  {
    $curriculum = $this->Curriculum->byId($id);

    if (empty($curriculum)) {
      return [
        'success' => false,
      ];
    }

    $this->Curriculum->update($request->all(), $curriculum);
    $curriculum = $this->Curriculum->byId($id);
    unset($curriculum->id);

    return [
      'success' => true,
      'curriculum' => $curriculum,
      'id' => $id,
    ];

  }

  public function delete($id)
  {
    $Curriculum = $this->Curriculum->byId($id);

    if (empty($Curriculum)) {
      return false;
    }

    $this->Curriculum->delete($id);

    return true;
  }
}
