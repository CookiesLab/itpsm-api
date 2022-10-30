<?php

/**
 * @file
 * Section Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\Section;

use App\Repositories\Section\SectionInterface;
use Carbon\Carbon;

class SectionManager
{
  /**
   * Section
   *
   * @var App\Repositories\Section\SectionInterface;
   *
   */
  protected $Section;

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
    SectionInterface $Section,
    Carbon $Carbon
  ) {
    $this->Section = $Section;
    $this->Carbon = $Carbon;
    $this->responseType = 'sections';
  }

  public function getTableRowsWithPagination($request, $pager = true)
  {
    $rows = [];
    $limit = $offset = $count = $page = $totalPages = 0;
    $filter = $sortColumn = $sortOrder = $customQuery =  '';

    if (!empty($request['filter']))
    {
      $filter = $request['filter'];
    }

    if (!empty($request['query']))
    {
      $customQuery = json_decode($request['query'], true)['query'];
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
      $count = $this->Section->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder, $customQuery);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->Section->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder, $customQuery)->each(function ($section) use (&$rows) {

      // $id = strval($section->id);
      // unset($section->id);

      array_push($rows, [
        'type' => $this->responseType,
        // 'id' => $id,
        'attributes' => $section
      ]);
    });

    return [
      'rows' => $rows,
      'page' => $page,
      'totalPages' => $totalPages,
      'records' => $count,
    ];
  }

  public function getSection($id)
  {
    return $this->Section->byId($id);
  }

  public function getByCurriculumIdAndLevel($periodId, $curriculumId, $level)
  {
    return $this->Section->byCurriculumIdAndLevel($periodId, $curriculumId, $level);
  }

  public function create($request)
  {
    $data = $request->all();
    $data['schedule']=0;
    $data['code'] = $this->generateCode($data['curriculum_subject_id'], $data['period_id']);
    $section = $this->Section->create($data);
    $id = strval($section->id);
    unset($section->id);

    return [
      'success' => true,
      'section' => $section,
      'period_sections' => $this->Section->getSectionsByPeriodId($section->period_id),
      'id' => $id,
    ];
  }

  public function update($request, $id)
  {
    $section = $this->Section->byId($id);

    if (empty($section)) {
      return [
        'success' => false,
      ];
    }

    $this->Section->update($request->all(), $section);
    $section = $this->Section->byId($id);
    unset($section->id);

    return [
      'success' => true,
      'section' => $section,
      'period_sections' => $this->Section->getSectionsByPeriodId($section->period_id),
      'id' => $id,
    ];

  }

  public function delete($id)
  {
    $section = $this->Section->byId($id);

    if (empty($section)) {
      return [
        'success' => false,
      ];
    }

    $this->Section->delete($id);

    return [
      'success' => true,
      'period_sections' => $this->Section->getSectionsByPeriodId($section->period_id),
      'id' => $id,
    ];
  }
  public function getSections($id)
  {
    $section = $this->Section->byStudentId($id);

    if (empty($section)) {
      return [
        'success' => false,
      ];
    }

 

    return [
      'success' => true,
      'period_sections' => $section,
      'id' => $id,
    ];
  }
  private function generateCode($curriculumSubjectId, $periodId) {
    $code = $this->Section->countCurriculumSubjectByPeriod($curriculumSubjectId, $periodId) + 1;
    return $code;
  }
}
