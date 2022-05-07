<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentCurriculaRequest;
use Illuminate\Http\Request;
use App\Services\StudentCurricula\StudentCurriculaManager;

class StudentCurriculaController extends Controller
{
  /**
   * StudentCurricula Manager Service
   *
   * @var App\Services\StudentCurriculaManager\StudentCurriculaManagementInterface;
   *
   */
  protected $StudentCurriculaManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    StudentCurriculaManager $StudentCurriculaManagerService
  ) {
    $this->StudentCurriculaManagerService = $StudentCurriculaManagerService;
    $this->responseType = 'student_curricula';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $response = $this->StudentCurriculaManagerService->getTableRowsWithPagination(request()->all());

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
  public function store(StudentCurriculaRequest $request)
  {
    $response = $this->StudentCurriculaManagerService->create($request);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $response['id'],
        'attributes' => $response['student_curricula']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\StudentCurricula  $StudentCurricula
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $studentCurricula = $this->StudentCurriculaManagerService->getStudentCurricula($id);

    if (empty($studentCurricula)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.StudentCurriculaNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    $id = strval($studentCurricula->id);
    unset($studentCurricula->id);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $studentCurricula
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
   * @param  \App\Models\StudentCurricula  $StudentCurricula
   * @return \Illuminate\Http\Response
   */
  public function update(StudentCurriculaRequest $request, $data)
  {
    $response = $this->StudentCurriculaManagerService->update($request, $data);

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
        'attributes' => $response['student_curricula']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\StudentCurricula  $StudentCurricula
   * @return \Illuminate\Http\Response
   */
  public function destroy($request)
  {
    $response = $this->StudentCurriculaManagerService->delete($request);

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
