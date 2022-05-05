<?php

/**
 * @file
 * Subject Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\Subject;

use App\Repositories\Subject\SubjectInterface;
use Carbon\Carbon;

class SubjectManager
{
  /**
   * Subject
   *
   * @var App\Repositories\Subject\SubjectInterface;
   *
   */
  protected $Subject;

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
    SubjectInterface $Subject,
    Carbon $Carbon
  ) {
    $this->Subject = $Subject;
    $this->Carbon = $Carbon;
    $this->responseType = 'subjects';
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
      $count = $this->Subject->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->Subject->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder)->each(function ($subject) use (&$rows) {

      $id = strval($subject->id);
      unset($subject->id);

      array_push($rows, [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $subject
      ]);
    });

    return [
      'rows' => $rows,
      'page' => $page,
      'totalPages' => $totalPages,
      'records' => $count,
    ];
  }

  public function getSubject($id)
  {
    return $this->Subject->byId($id);
  }

  public function create($request)
  {
    $subject = $this->Subject->create($request->all());
    $id = strval($subject->id);
    unset($subject->id);

    return [
      'success' => true,
      'subject' => $subject,
      'id' => $id,
    ];
  }

  public function update($request, $id)
  {
    $subject = $this->Subject->byId($id);

    if (empty($subject)) {
      return [
        'success' => false,
      ];
    }

    $this->Subject->update($request->all(), $subject);
    $subject = $this->Subject->byId($id);
    unset($subject->id);

    return [
      'success' => true,
      'subject' => $subject,
      'id' => $id,
    ];

  }

  public function delete($id)
  {
    $Subject = $this->Subject->byId($id);

    if (empty($Subject)) {
      return false;
    }

    $this->Subject->delete($id);

    return true;
  }
}
