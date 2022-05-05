<?php

namespace App\Http\Controllers;

use App\Http\Requests\CareerRequest;
use Illuminate\Http\Request;
use App\Services\Career\CareerManager;

class CareerController extends Controller
{
  /**
   * Career Manager Service
   *
   * @var App\Services\CareerManager\CareerManagementInterface;
   *
   */
  protected $CareerManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    CareerManager $CareerManagerService
  ) {
    $this->CareerManagerService = $CareerManagerService;
    $this->responseType = 'careers';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $response = $this->CareerManagerService->getTableRowsWithPagination(request()->all());

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
  public function store(CareerRequest $request)
  {
    $response = $this->CareerManagerService->create($request);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $response['id'],
        'attributes' => $response['career']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Career  $Career
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $career = $this->CareerManagerService->getCareer($id);

    if (empty($career)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.CareerNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    $id = strval($career->id);
    unset($career->id);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $career
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
   * @param  \App\Models\Career  $Career
   * @return \Illuminate\Http\Response
   */
  public function update(CareerRequest $request, $data)
  {
    $response = $this->CareerManagerService->update($request, $data);

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
        'attributes' => $response['career']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Career  $Career
   * @return \Illuminate\Http\Response
   */
  public function destroy($request)
  {
    $response = $this->CareerManagerService->delete($request);

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
