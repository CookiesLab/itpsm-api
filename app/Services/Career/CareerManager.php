<?php

/**
 * @file
 * Career Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\Career;

use App\Repositories\Career\CareerInterface;
use Carbon\Carbon;

class CareerManager
{
  /**
   * Career
   *
   * @var App\Repositories\Career\CareerInterface;
   *
   */
  protected $Career;

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
    CareerInterface $Career,
    Carbon $Carbon
  ) {
    $this->Career = $Career;
    $this->Carbon = $Carbon;
    $this->responseType = 'careers';
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
      $count = $this->Career->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->Career->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder)->each(function ($career) use (&$rows) {

      $career->birth_date_with_format = !empty($career->birth_date)? $this->Carbon->createFromFormat('Y-m-d', $career->birth_date, config('app.timezone'))->format('d/m/Y') : null;
      $id = strval($career->id);
      unset($career->id);

      array_push($rows, [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $career
      ]);
    });

    return [
      'rows' => $rows,
      'page' => $page,
      'totalPages' => $totalPages,
      'records' => $count,
    ];
  }

  public function getCareer($id)
  {
    return $this->Career->byId($id);
  }

  public function create($request)
  {
    $career = $this->Career->create($request->all());
    $id = strval($career->id);
    unset($career->id);

    return [
      'success' => true,
      'career' => $career,
      'id' => $id,
    ];
  }

  public function update($request, $id)
  {
    $career = $this->Career->byId($id);

    if (empty($career)) {
      return [
        'success' => false,
      ];
    }

    $this->Career->update($request->all(), $career);
    $career = $this->Career->byId($id);
    unset($career->id);

    return [
      'success' => true,
      'career' => $career,
      'id' => $id,
    ];

  }

  public function delete($id)
  {
    $Career = $this->Career->byId($id);

    if (empty($Career)) {
      return false;
    }

    $this->Career->delete($id);

    return true;
  }
}
