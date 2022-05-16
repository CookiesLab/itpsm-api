<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnrollmentRequest;
use Illuminate\Http\Request;
use App\Services\Enrollment\EnrollmentManager;

class EnrollmentController extends Controller
{
  /**
   * Enrollment Manager Service
   *
   * @var App\Services\EnrollmentManager\EnrollmentManagementInterface;
   *
   */
  protected $EnrollmentManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    EnrollmentManager $EnrollmentManagerService
  ) {
    $this->EnrollmentManagerService = $EnrollmentManagerService;
    $this->responseType = 'enrollments';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $response = $this->EnrollmentManagerService->getTableRowsWithPagination(request()->all());

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
  public function store(EnrollmentRequest $request)
  {
    $response = $this->EnrollmentManagerService->create($request);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $response['id'],
        'attributes' => $response['enrollment']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Enrollment  $Enrollment
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $enrollment = $this->EnrollmentManagerService->getEnrollment($id);

    if (empty($enrollment)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.EnrollmentNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'attributes' => $enrollment
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
   * @param  \App\Models\Enrollment  $Enrollment
   * @return \Illuminate\Http\Response
   */
  public function update(EnrollmentRequest $request, $data)
  {
    $response = $this->EnrollmentManagerService->update($request, $data);

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
        'attributes' => $response['enrollment']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Enrollment  $Enrollment
   * @return \Illuminate\Http\Response
   */
  public function destroy($request)
  {
    $response = $this->EnrollmentManagerService->delete($request);

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
