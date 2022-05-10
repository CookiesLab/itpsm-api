<?php

/**
 * @file
 * Period Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\Period;

use App\Repositories\Period\PeriodInterface;
use Carbon\Carbon;

class PeriodManager
{
  /**
   * Period
   *
   * @var App\Repositories\Period\PeriodInterface;
   *
   */
  protected $Period;

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
    PeriodInterface $Period,
    Carbon $Carbon
  ) {
    $this->Period = $Period;
    $this->Carbon = $Carbon;
    $this->responseType = 'periods';
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
      $count = $this->Period->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->Period->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder)->each(function ($period) use (&$rows) {

      $period->label = str_pad($period->code, 2, "0", STR_PAD_LEFT)."-".$period->year
      $id = strval($period->id);
      unset($period->id);

      array_push($rows, [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $period
      ]);
    });

    return [
      'rows' => $rows,
      'page' => $page,
      'totalPages' => $totalPages,
      'records' => $count,
    ];
  }

  public function getPeriod($id)
  {
    return $this->Period->byId($id);
  }

  public function create($request)
  {
    $period = $this->Period->create($request->all());
    $id = strval($period->id);
    unset($period->id);

    return [
      'success' => true,
      'period' => $period,
      'id' => $id,
    ];
  }

  public function update($request, $id)
  {
    $period = $this->Period->byId($id);

    if (empty($period)) {
      return [
        'success' => false,
      ];
    }

    $this->Period->update($request->all(), $period);
    $period = $this->Period->byId($id);
    unset($period->id);

    return [
      'success' => true,
      'period' => $period,
      'id' => $id,
    ];

  }

  public function delete($id)
  {
    $Period = $this->Period->byId($id);

    if (empty($Period)) {
      return false;
    }

    $this->Period->delete($id);

    return true;
  }
}
