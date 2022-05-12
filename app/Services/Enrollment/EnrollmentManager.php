<?php

/**
 * @file
 * Enrollment Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\Enrollment;

use App\Repositories\Enrollment\EnrollmentInterface;
use Carbon\Carbon;

class EnrollmentManager
{
  /**
   * Enrollment
   *
   * @var App\Repositories\Enrollment\EnrollmentInterface;
   *
   */
  protected $Enrollment;

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
    EnrollmentInterface $Enrollment,
    Carbon $Carbon
  ) {
    $this->Enrollment = $Enrollment;
    $this->Carbon = $Carbon;
    $this->responseType = 'enrollments';
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
      $count = $this->Enrollment->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->Enrollment->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder)->each(function ($enrollment) use (&$rows) {

      $id = strval($enrollment->id);
      unset($enrollment->id);

      array_push($rows, [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $enrollment
      ]);
    });

    return [
      'rows' => $rows,
      'page' => $page,
      'totalPages' => $totalPages,
      'records' => $count,
    ];
  }

  public function getEnrollment($id)
  {
    return $this->Enrollment->byId($id);
  }

  public function create($request)
  {
    $enrollment = $this->Enrollment->create($request->all());
    $id = strval($enrollment->id);
    unset($enrollment->id);

    return [
      'success' => true,
      'enrollment' => $enrollment,
      'id' => $id,
    ];
  }

  public function update($request, $id)
  {
    $enrollment = $this->Enrollment->byId($id);

    if (empty($enrollment)) {
      return [
        'success' => false,
      ];
    }

    $this->Enrollment->update($request->all(), $enrollment);
    $enrollment = $this->Enrollment->byId($id);
    unset($enrollment->id);

    return [
      'success' => true,
      'enrollment' => $enrollment,
      'id' => $id,
    ];

  }

  public function delete($id)
  {
    $Enrollment = $this->Enrollment->byId($id);

    if (empty($Enrollment)) {
      return false;
    }

    $this->Enrollment->delete($id);

    return true;
  }
}
