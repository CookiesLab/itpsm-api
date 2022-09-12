<?php

/**
 * @file
 * StudentCurricula Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\StudentCurricula;

use App\Repositories\StudentCurricula\StudentCurriculaInterface;
use Carbon\Carbon;

class StudentCurriculaManager
{
  /**
   * StudentCurricula
   *
   * @var App\Repositories\StudentCurricula\StudentCurriculaInterface;
   *
   */
  protected $StudentCurricula;

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
    StudentCurriculaInterface $StudentCurricula,
    Carbon $Carbon
  ) {
    $this->StudentCurricula = $StudentCurricula;
    $this->Carbon = $Carbon;
    $this->responseType = 'student_curricula';
  }

  public function getTableRowsWithPagination($request, $pager = true)
  {
    $rows = [];
    $limit = $offset = $count = $page = $totalPages = 0;
    $filter = $sortColumn = $sortOrder = $customQuery = '';

    if (!empty($request['query']))
    {
      $customQuery = json_decode($request['query'], true)['query'];
    }

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
      $count = $this->StudentCurricula->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder, $customQuery);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->StudentCurricula->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder, $customQuery)->each(function ($studentCurricula) use (&$rows) {

      // $id = strval($studentCurricula->id);
      // unset($studentCurricula->id);

      array_push($rows, [
        'type' => $this->responseType,
        //'id' => $id,
        'attributes' => $studentCurricula
      ]);
    });

    return [
      'rows' => $rows,
      'page' => $page,
      'totalPages' => $totalPages,
      'records' => $count,
    ];
  }

  public function getStudentCurricula($id)
  {
    return $this->StudentCurricula->byId($id);
  }

  public function getActiveCurriculaByStudentId($studentId)
  {
    return $this->StudentCurricula->activeCurriculaByStudentId($studentId);
  }

  public function create($request)
  {
    $studentCurricula = $this->StudentCurricula->create($request->all());
    $id = strval($studentCurricula->id);
    unset($studentCurricula->id);

    return [
      'success' => true,
      'student_curricula' => $studentCurricula,
      'id' => $id,
    ];
  }

  public function update($request, $id)
  {
    $studentCurricula = $this->StudentCurricula->byId($id);

    if (empty($studentCurricula)) {
      return [
        'success' => false,
      ];
    }

    $this->StudentCurricula->update($request->all(), $studentCurricula);
    $studentCurricula = $this->StudentCurricula->byId($id);
    unset($studentCurricula->id);

    return [
      'success' => true,
      'student_curricula' => $studentCurricula,
      'id' => $id,
    ];

  }

  public function delete($id)
  {
    $StudentCurricula = $this->StudentCurricula->byId($id);

    if (empty($StudentCurricula)) {
      return false;
    }

    $this->StudentCurricula->delete($id);

    return true;
  }
}
