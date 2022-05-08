<?php

/**
 * @file
 * Prerequisite Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\Prerequisite;

use App\Repositories\Prerequisite\PrerequisiteInterface;
use Carbon\Carbon;

class PrerequisiteManager
{
  /**
   * Prerequisite
   *
   * @var App\Repositories\Prerequisite\PrerequisiteInterface;
   *
   */
  protected $Prerequisite;

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
    PrerequisiteInterface $Prerequisite,
    Carbon $Carbon
  ) {
    $this->Prerequisite = $Prerequisite;
    $this->Carbon = $Carbon;
    $this->responseType = 'prerequisites';
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
      $count = $this->Prerequisite->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->Prerequisite->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder)->each(function ($prerequisite) use (&$rows) {

      // $id = strval($prerequisite->id);
      // unset($prerequisite->id);

      array_push($rows, [
        'type' => $this->responseType,
        // 'id' => $id,
        'attributes' => $prerequisite
      ]);
    });

    return [
      'rows' => $rows,
      'page' => $page,
      'totalPages' => $totalPages,
      'records' => $count,
    ];
  }

  public function getPrerequisiteByCurriculumSubjectId($id)
  {
    return $this->Prerequisite->byId($id);
  }

  public function create($request)
  {
    $prerequisite = $this->Prerequisite->create($request->all());
    $id = strval($prerequisite->id);
    unset($prerequisite->id);

    return [
      'success' => true,
      'prerequisite' => $prerequisite,
      'id' => $id,
    ];
  }

  public function update($request, $id)
  {
    $prerequisite = $this->Prerequisite->byId($id);

    if (empty($prerequisite)) {
      return [
        'success' => false,
      ];
    }

    $this->Prerequisite->update($request->all(), $prerequisite);
    $prerequisite = $this->Prerequisite->byId($id);
    unset($prerequisite->id);

    return [
      'success' => true,
      'prerequisite' => $prerequisite,
      'id' => $id,
    ];

  }

  public function delete($id)
  {
    $Prerequisite = $this->Prerequisite->byId($id);

    if (empty($Prerequisite)) {
      return false;
    }

    $this->Prerequisite->delete($id);

    return true;
  }
}
