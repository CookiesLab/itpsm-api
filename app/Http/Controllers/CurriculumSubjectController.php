<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurriculumSubjectRequest;
use Illuminate\Http\Request;
use App\Services\CurriculumSubject\CurriculumSubjectManager;

class CurriculumSubjectController extends Controller
{
  /**
   * CurriculumSubject Manager Service
   *
   * @var App\Services\CurriculumSubjectManager\CurriculumSubjectManagementInterface;
   *
   */
  protected $CurriculumSubjectManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    CurriculumSubjectManager $CurriculumSubjectManagerService
  ) {
    $this->CurriculumSubjectManagerService = $CurriculumSubjectManagerService;
    $this->responseType = 'curriculumSubjects';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $response = $this->CurriculumSubjectManagerService->getTableRowsWithPagination(request()->all());

    return response()->json([
      'meta' => [
        'page' => $response['page'],
        'totalPages' => $response['totalPages'],
        'records' => $response['records'],
      ],
      'data' => $response['rows'],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CurriculumSubjectRequest $request)
  {
    $response = $this->CurriculumSubjectManagerService->create($request);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $response['id'],
        'attributes' => $response['curriculumSubject']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\CurriculumSubject  $CurriculumSubject
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $curriculumSubject = $this->CurriculumSubjectManagerService->getCurriculumSubject($id);

    if (empty($curriculumSubject)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.CurriculumSubjectNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    $id = strval($curriculumSubject->id);
    unset($curriculumSubject->id);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $curriculumSubject
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \App\Models\CurriculumSubject  $CurriculumSubject
   * @return \Illuminate\Http\Response
   */
  public function update(CurriculumSubjectRequest $request, $data)
  {
    $response = $this->CurriculumSubjectManagerService->update($request, $data);

    if (!$response['success']) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.notFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $response['id'],
        'attributes' => $response['curriculumSubject']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\CurriculumSubject  $CurriculumSubject
   * @return \Illuminate\Http\Response
   */
  public function destroy($request)
  {
    $response = $this->CurriculumSubjectManagerService->delete($request);

    if (!$response) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.notFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

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
