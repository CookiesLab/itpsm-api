<?php

/**
 * @file
 * Section Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\Schedule;

use App\Repositories\Schedule\ScheduleInterface;

use Carbon\Carbon;

class ScheduleManager
{
  /**
   * Section
   *
   * @var App\Repositories\Schedule\ScheduleInterface;
   *
   */
  protected $Schedule;

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
    ScheduleInterface $Schedule,
    Carbon $Carbon
  ) {
    $this->Schedule = $Schedule;
    $this->Carbon = $Carbon;
    $this->responseType = 'schedule';
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
      $count = $this->Schedule->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder, $customQuery);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->Schedule->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder, $customQuery)->each(function ($section) use (&$rows) {

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
    return $this->Schedule->byId($id);
  }

  public function getByCurriculumIdAndLevel($periodId, $curriculumId, $level)
  {
    return $this->Schedule->byCurriculumIdAndLevel($periodId, $curriculumId, $level);
  }

  public function create($request)
  {
    $data = $request->all();
    $data['code'] = $this->generateCode($data['curriculum_subject_id'], $data['period_id']);
    $section = $this->Schedule->create($data);
    $id = strval($section->id);
    unset($section->id);

    return [
      'success' => true,
      'section' => $section,
      'period_sections' => $this->Schedule->getSectionsByPeriodId($section->period_id),
      'id' => $id,
    ];
  }

  public function update($request, $id)
  {
    $section = $this->Schedule->byId($id);

    if (empty($section)) {
      return [
        'success' => false,
      ];
    }

    $this->Schedule->update($request->all(), $section);
    $section = $this->Schedule->byId($id);
    unset($section->id);

    return [
      'success' => true,
      'section' => $section,
      'period_sections' => $this->Schedule->getSectionsByPeriodId($section->period_id),
      'id' => $id,
    ];

  }

  public function delete($id)
  {
    $section = $this->Schedule->byId($id);

    if (empty($section)) {
      return [
        'success' => false,
      ];
    }

    $this->Schedule->delete($id);

    return [
      'success' => true,
      'period_sections' => $this->Schedule->getSectionsByPeriodId($section->period_id),
      'id' => $id,
    ];
  }

  private function generateCode($curriculumSubjectId, $periodId) {
    $code = $this->Schedule->countCurriculumSubjectByPeriod($curriculumSubjectId, $periodId) + 1;
    return $code;
  }
}
