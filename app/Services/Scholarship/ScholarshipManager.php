<?php

/**
 * @file
 * Scholarship Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\Scholarship;

use App\Repositories\Scholarship\ScholarshipInterface;
use Carbon\Carbon;

class ScholarshipManager
{
  /**
   * Scholarship
   *
   * @var App\Repositories\Scholarship\ScholarshipInterface;
   *
   */
  protected $Scholarship;

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
    ScholarshipInterface $Scholarship,
    Carbon $Carbon
  ) {
    $this->Scholarship = $Scholarship;
    $this->Carbon = $Carbon;
    $this->responseType = 'scholarships';
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
      $count = $this->Scholarship->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->Scholarship->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder)->each(function ($scholarship) use (&$rows) {

      $id = strval($scholarship->id);
      unset($scholarship->id);

      array_push($rows, [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $scholarship
      ]);
    });

    return [
      'rows' => $rows,
      'page' => $page,
      'totalPages' => $totalPages,
      'records' => $count,
    ];
  }

  public function getScholarship($id)
  {
    return $this->Scholarship->byId($id);
  }

  public function create($request)
  {
    $scholarship = $this->Scholarship->create($request->all());
    $id = strval($scholarship->id);
    unset($scholarship->id);

    return [
      'success' => true,
      'scholarship' => $scholarship,
      'id' => $id,
    ];
  }

  public function update($request, $id)
  {
    $scholarship = $this->Scholarship->byId($id);

    if (empty($scholarship)) {
      return [
        'success' => false,
      ];
    }

    $this->Scholarship->update($request->all(), $scholarship);
    $scholarship = $this->Scholarship->byId($id);
    unset($scholarship->id);

    return [
      'success' => true,
      'scholarship' => $scholarship,
      'id' => $id,
    ];

  }

  public function delete($id)
  {
    $Scholarship = $this->Scholarship->byId($id);

    if (empty($Scholarship)) {
      return false;
    }

    $this->Scholarship->delete($id);

    return true;
  }
}
