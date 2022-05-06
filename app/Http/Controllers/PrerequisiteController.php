<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrerequisiteRequest;
use Illuminate\Http\Request;
use App\Services\Prerequisite\PrerequisiteManager;

class PrerequisiteController extends Controller
{
  /**
   * Prerequisite Manager Service
   *
   * @var App\Services\PrerequisiteManager\PrerequisiteManagementInterface;
   *
   */
  protected $PrerequisiteManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    PrerequisiteManager $PrerequisiteManagerService
  ) {
    $this->PrerequisiteManagerService = $PrerequisiteManagerService;
    $this->responseType = 'prerequisites';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $response = $this->PrerequisiteManagerService->getTableRowsWithPagination(request()->all());

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
  public function store(PrerequisiteRequest $request)
  {
    $response = $this->PrerequisiteManagerService->create($request);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $response['id'],
        'attributes' => $response['prerequisite']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Prerequisite  $Prerequisite
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $prerequisite = $this->PrerequisiteManagerService->getPrerequisiteByCurriculumSubjectId($id);

    if (empty($prerequisite)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.PrerequisiteNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    $id = strval($prerequisite->id);
    unset($prerequisite->id);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $prerequisite
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
   * @param  \App\Models\Prerequisite  $Prerequisite
   * @return \Illuminate\Http\Response
   */
  public function update(PrerequisiteRequest $request, $data)
  {
    $response = $this->PrerequisiteManagerService->update($request, $data);

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
        'attributes' => $response['prerequisite']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Prerequisite  $Prerequisite
   * @return \Illuminate\Http\Response
   */
  public function destroy($request)
  {
    $response = $this->PrerequisiteManagerService->delete($request);

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
