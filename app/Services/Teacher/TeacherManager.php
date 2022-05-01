<?php

/**
 * @file
 * Teacher Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\Teacher;

use App\Repositories\Teacher\TeacherInterface;
use Carbon\Carbon;

class TeacherManager
{
  /**
   * Teacher
   *
   * @var App\Repositories\Teacher\TeacherInterface;
   *
   */
  protected $Teacher;

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
    TeacherInterface $Teacher,
    Carbon $Carbon
  ) {
    $this->Teacher = $Teacher;
    $this->Carbon = $Carbon;
    $this->responseType = 'teachers';
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
      $count = $this->Teacher->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->Teacher->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder)->each(function ($teacher) use (&$rows) {

      $teacher->birth_date_with_format = !empty($teacher->birth_date)? $this->Carbon->createFromFormat('Y-m-d', $teacher->birth_date, config('app.timezone'))->format('d/m/Y') : null;
      $id = strval($teacher->id);
      unset($teacher->id);

      array_push($rows, [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $teacher
      ]);
    });

    return [
      'rows' => $rows,
      'page' => $page,
      'totalPages' => $totalPages,
      'records' => $count,
    ];
  }

  public function getTeacher($id)
  {
    return $this->Teacher->byId($id);
  }

  public function create($request)
  {
    $teacher = $this->Teacher->create($request->all());
    $id = strval($teacher->id);
    unset($teacher->id);

    return [
      'success' => true,
      'teacher' => $teacher,
      'id' => $id,
    ];
  }

  public function update($request, $id)
  {
    $teacher = $this->Teacher->byId($id);

    if (empty($teacher)) {
      return [
        'success' => false,
      ];
    }

    $this->Teacher->update($request->all(), $teacher);
    $teacher = $this->Teacher->byId($id);
    unset($teacher->id);

    return [
      'success' => true,
      'teacher' => $teacher,
      'id' => $id,
    ];

  }

  public function delete($id)
  {
    $Teacher = $this->Teacher->byId($id);

    if (empty($Teacher)) {
      return false;
    }

    $this->Teacher->delete($id);

    return true;
  }
}
