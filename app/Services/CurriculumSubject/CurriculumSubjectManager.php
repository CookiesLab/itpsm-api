<?php

/**
 * @file
 * CurriculumSubject Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\CurriculumSubject;

use App\Repositories\CurriculumSubject\CurriculumSubjectInterface;
use App\Services\Prerequisite\PrerequisiteManager;
use Carbon\Carbon;

class CurriculumSubjectManager
{
  /**
   * CurriculumSubject
   *
   * @var App\Repositories\CurriculumSubject\CurriculumSubjectInterface;
   *
   */
  protected $CurriculumSubject;

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
    CurriculumSubjectInterface $CurriculumSubject,
    Carbon $Carbon
  ) {
    $this->CurriculumSubject = $CurriculumSubject;
    $this->Carbon = $Carbon;
    $this->responseType = 'curriculum_subjects';
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
      $count = $this->CurriculumSubject->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->CurriculumSubject->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder)->each(function ($curriculumSubject) use (&$rows) {

      $curriculumSubject->prerequisites = $this->PrerequisiteManager->getPrerequisiteByCurriculumSubjectId($curriculumSubject->id);
      $id = strval($curriculumSubject->id);
      unset($curriculumSubject->id);

      array_push($rows, [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $curriculumSubject
      ]);
    });

    return [
      'rows' => $rows,
      'page' => $page,
      'totalPages' => $totalPages,
      'records' => $count,
    ];
  }

  public function getCurriculumSubject($id)
  {
    return $this->CurriculumSubject->byId($id);
  }

  public function create($request)
  {
    $curriculumSubject = $this->CurriculumSubject->create($request->all());
    $id = strval($curriculumSubject->id);
    unset($curriculumSubject->id);

    return [
      'success' => true,
      'curriculum_subject' => $curriculumSubject,
      'id' => $id,
    ];
  }

  public function update($request, $id)
  {
    $curriculumSubject = $this->CurriculumSubject->byId($id);

    if (empty($curriculumSubject)) {
      return [
        'success' => false,
      ];
    }

    $this->CurriculumSubject->update($request->all(), $curriculumSubject);
    $curriculumSubject = $this->CurriculumSubject->byId($id);
    unset($curriculumSubject->id);

    return [
      'success' => true,
      'curriculum_subject' => $curriculumSubject,
      'id' => $id,
    ];

  }

  public function delete($id)
  {
    $CurriculumSubject = $this->CurriculumSubject->byId($id);

    if (empty($CurriculumSubject)) {
      return false;
    }

    $this->CurriculumSubject->delete($id);

    return true;
  }
}
