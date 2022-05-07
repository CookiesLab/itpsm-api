<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScholarshipRequest;
use Illuminate\Http\Request;
use App\Services\Scholarship\ScholarshipManager;

class ScholarshipController extends Controller
{
  /**
   * Scholarship Manager Service
   *
   * @var App\Services\ScholarshipManager\ScholarshipManagementInterface;
   *
   */
  protected $ScholarshipManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    ScholarshipManager $ScholarshipManagerService
  ) {
    $this->ScholarshipManagerService = $ScholarshipManagerService;
    $this->responseType = 'scholarships';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $response = $this->ScholarshipManagerService->getTableRowsWithPagination(request()->all());

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
  public function store(ScholarshipRequest $request)
  {
    $response = $this->ScholarshipManagerService->create($request);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $response['id'],
        'attributes' => $response['scholarship']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Scholarship  $Scholarship
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $scholarship = $this->ScholarshipManagerService->getScholarship($id);

    if (empty($scholarship)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.ScholarshipNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    $id = strval($scholarship->id);
    unset($scholarship->id);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $scholarship
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
   * @param  \App\Models\Scholarship  $Scholarship
   * @return \Illuminate\Http\Response
   */
  public function update(ScholarshipRequest $request, $data)
  {
    $response = $this->ScholarshipManagerService->update($request, $data);

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
        'attributes' => $response['scholarship']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Scholarship  $Scholarship
   * @return \Illuminate\Http\Response
   */
  public function destroy($request)
  {
    $response = $this->ScholarshipManagerService->delete($request);

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
