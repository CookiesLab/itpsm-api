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
   * PrerequisiteManager
   *
   * @var App\Services\Prerequisite\PrerequisiteManager;
   *
   */
  protected $PrerequisiteManager;

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
    PrerequisiteManager $PrerequisiteManager,
    Carbon $Carbon
  ) {
    $this->CurriculumSubject = $CurriculumSubject;
    $this->PrerequisiteManager = $PrerequisiteManager;
    $this->Carbon = $Carbon;
    $this->responseType = 'curriculum_subjects';
  }

  public function getTableRowsWithPagination($request, $pager = true)
  {
    $rows = [];
    $limit = $offset = $count = $page = $totalPages = 0;
    $filter = $sortColumn = $sortOrder = $customQuery = '';

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
    else
    {
      $sortColumn = 'id';
      $sortOrder = 'asc';
    }

    if ($pager)
    {
      $count = $this->CurriculumSubject->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder, $customQuery);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->CurriculumSubject->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder, $customQuery)->each(function ($curriculumSubject) use (&$rows) {

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
      'curriculum_subjects' => $this->CurriculumSubject->getSubjectsByCurriculumId($curriculumSubject->curriculum_id),
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
      'curriculum_subjects' => $this->CurriculumSubject->getSubjectsByCurriculumId($curriculumSubject->curriculum_id),
      'id' => $id,
    ];

  }

  public function delete($id)
  {
    $CurriculumSubject = $this->CurriculumSubject->byId($id);

    if (empty($CurriculumSubject)) {
      return [
        'success' => false,
      ];
    }

    $this->CurriculumSubject->delete($id);

    return [
      'success' => true,
      'curriculum_subjects' => $this->CurriculumSubject->getSubjectsByCurriculumId($CurriculumSubject->curriculum_id),
      'id' => $id,
    ];
  }

  public function createCurriculumSubjects(array $input)
  {
    // Missing begin transaction
    try {
      $curriculumSubjectIds = array();
      $this->CurriculumSubject->byId($input['curriculum_id'])->each(function($CurriculumSubject) use (&$curriculumSubjectIds)
      {
        array_push($curriculumSubjectIds, $CurriculumSubject->id);
      });

      foreach ($input['subjects'] as $key => $item)
      {
        $curriculumSubject = array(
          'curriculum_id' => $item['curriculum_id'],
          'subject_id' => $item['subject_id'],
          'uv' => $item['uv'],
          'cycle' => $item['cycle']
        );

        if(isset($item['id']) && !empty($item['id']))
        {
          $curriculumSubject['id'] = $item['id'];
          $this->update($curriculumSubject, $item['id']);

          $key = array_search($curriculumSubject['id'], $curriculumSubjectIds);
          unset($curriculumSubjectIds[$key]);
        }
        else
        {
          $response = $this->create($curriculumSubject);
          $input['subjects'][$key]['id'] = $response['id'];
        }
      }

      if(!empty($curriculumSubjectIds))
      {
        foreach ($curriculumSubjectIds as $key => $id)
        {
          $this->delete($id);
        }
      }

      // Missing commit transaction
    }
    catch (\Exception $e)
    {
      // $this->rollBack($openTransaction);

      throw $e;
    }
    catch (\Throwable $e)
    {
      // $this->rollBack($openTransaction);

      throw $e;
    }

    return json_encode(
      array(
        'success' => $this->Lang->get('form.defaultSuccessSaveMessage'),
        'id' => $input['curriculum_id'],
        'articles' => $input['subjects']
      )
    );
  }
}
