<?php

/**
 * @file
 * Student Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\StudentManager;

use App\Repositories\Student\StudentInterface;
use Carbon\Carbon;

class StudentManager
{
  /**
   * Student
   *
   * @var App\Repositories\Student\StudentInterface;
   *
   */
  protected $Student;

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
    StudentInterface $Student,
    Carbon $Carbon
  ) {
    $this->Student = $Student;
    $this->Carbon = $Carbon;
    $this->responseType = 'students';
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
      $count = $this->Student->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->Student->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder)->each(function ($Student) use (&$rows) {
      $Student->price_label = '$ ' . number_format($Student->price, 2, __('base.decimalSeparator'), __('base.thousandsSeparator'));
      $id = strval($Student->id);
      unset($Student->id);

      array_push($rows, [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $Student
      ]);
    });

    $nextPage = ($page < $totalPages) ? $page + 1 : $totalPages;
    $prevPage = ($page > 1) ? $page - 1 : 1;

    return response()->json([
      'meta' => [
        'page' => $page,
        'totalPages' => $totalPages,
        'records' => $count,
      ],
      'data' => $rows,
      'links' => [
        "self" =>  url("/api/$this->responseType?page[number]=$page&page[size]=$limit"),
        "first" => url("/api/$this->responseType?page[number]=1&page[size]=$limit"),
        "prev" => url("/api/$this->responseType?page[number]=$prevPage&page[size]=$limit"),
        "next" => url("/api/$this->responseType?page[number]=$$nextPage&page[size]=$limit"),
        "last" => url("/api/$this->responseType?page[number]=$totalPages&page[size]=$limit")
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  public function getStudent($id)
  {
    $Student = $this->Student->byId($id);

    if (empty($Student)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.StudentNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    $id = strval($Student->id);
    unset($Student->id);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $Student
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  public function create($request)
  {
    $Student = $this->Student->create($request->all());
    $id = strval($Student->id);
    unset($Student->id);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $Student
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }

  public function update($request, $id)
  {
    $Student = $this->Student->byId($id);

    if (empty($Student)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.StudentNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    $this->Student->update($request->all(), $Student);
    $Student = $this->Student->byId($id);
    unset($Student->id);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $Student
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  public function delete($id)
  {
    $Student = $this->Student->byId($id);

    if (empty($Student)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.StudentNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    $this->Student->delete($id);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'success' => __('base.delete'),
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }
}
