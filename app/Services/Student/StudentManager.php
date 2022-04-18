<?php

/**
 * @file
 * Student Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\Student;

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

    $this->Student->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder)->each(function ($student) use (&$rows) {
      $id = strval($student->id);
      unset($student->id);

      array_push($rows, [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $student
      ]);
    });

    return [
      'rows' => $rows,
      'page' => $page,
      'totalPages' => $totalPages,
      'records' => $count,
    ];
  }

  public function getStudent($id)
  {
    return $this->Student->byId($id);
  }

  public function create($request)
  {
    $student = $this->Student->create($request->all());
    $id = strval($student->id);
    unset($student->id);

    return [
      'success' => true,
      'student' => $student,
      'id' => $id,
    ];
  }

  public function update($request, $id)
  {
    $student = $this->Student->byId($id);

    if (empty($student)) {
      return [
        'success' => false,
      ];
    }

    $this->Student->update($request->all(), $student);
    $student = $this->Student->byId($id);
    unset($student->id);

    return [
      'success' => true,
      'student' => $student,
      'id' => $id,
    ];

  }

  public function delete($id)
  {
    $Student = $this->Student->byId($id);

    if (empty($Student)) {
      return false;
    }

    $this->Student->delete($id);

    return true;
  }
}
