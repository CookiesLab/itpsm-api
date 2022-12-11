<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodRequest;
use Illuminate\Http\Request;
use App\Services\Period\PeriodManager;

class PeriodController extends Controller
{
  /**
   * Period Manager Service
   *
   * @var App\Services\PeriodManager\PeriodManagementInterface;
   *
   */
  protected $PeriodManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    PeriodManager $PeriodManagerService
  ) {
    $this->PeriodManagerService = $PeriodManagerService;
    $this->responseType = 'periods';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
     /**
   *  @OA\Get(
   *    path="/api/periods",
   *    operationId="getPeriods",
   *    tags={"Periods"},
   * security={{"bearer_token":{}}},
   *    summary="Get periods list",
   *    description="Returns periods list",
   *
   *    @OA\Response(
   *      response=200,
   *      description="Success",
   *      @OA\MediaType(
   *        mediaType="application/json",
   *      )
   *    ),
   *    @OA\Response(
   *      response=401,
   *      description="Unauthenticated",
   *    ),
   *    @OA\Response(
   *      response=403,
   *      description="Forbidden",
   *    ),
   *    @OA\Response(
   *      response=400,
   *      description="Bad Request"
   *    ),
   *    @OA\Response(
   *      response=404,
   *      description="Not Found"
   *    )
   *  )
  */
  public function index()
  {
    $response = $this->PeriodManagerService->getTableRowsWithPagination(request()->all());

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
     /**
   *  @OA\Post(
   *    path="/api/periods",
   *    operationId="postPeriods",
   *    tags={"Periods"},
   * security={{"bearer_token":{}}},
   *    summary="Create period",
   *    description="Create period",
   *
   *    @OA\Parameter(
   *      name="code",
   *      in="query",
   *      description="Period name to create",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="year",
   *      in="query",
   *      description="Period year",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
      *
      *      *    @OA\Parameter(
      *      name="status",
      *      in="query",
      *      description="Status",
      *      required=true,
      *      @OA\Schema(
      *        type="string",
      *      )
      *    ),
   *
   *    @OA\Response(
   *      response=200,
   *      description="Success",
   *      @OA\MediaType(
   *        mediaType="application/json",
   *      ),
   *    ),
   *    @OA\Response(
   *      response=401,
   *      description="Unauthenticated",
   *    ),
   *    @OA\Response(
   *      response=403,
   *      description="Forbidden",
   *    ),
   *    @OA\Response(
   *      response=400,
   *      description="Bad Request"
   *    ),
   *    @OA\Response(
   *      response=404,
   *      description="Not Found"
   *    )
   *  )
  */
  public function store(PeriodRequest $request)
  {
    $response = $this->PeriodManagerService->create($request);
    if($response['success']){
      return response()->json([
        'data' => [
          'type' => $this->responseType,
          'id' => $response['id'],
          'attributes' => $response['period']
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 201);
    }

      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.createperiod'),
          'detail' => __('base.createperiod')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);



  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Period  $Period
   * @return \Illuminate\Http\Response
   */
    /**
   *  @OA\Get(
   *    path="/api/periods/{id}",
   *    operationId="get period by id",
   *    tags={"Periods"},
   * security={{"bearer_token":{}}},
   *    summary="Get period by id",
   *    description="Returns period by id",
   *
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="Period id",
   *      required=true,
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   *
   *    @OA\Response(
   *      response=200,
   *      description="Success",
   *      @OA\MediaType(
   *        mediaType="application/json",
   *      )
   *    ),
   *    @OA\Response(
   *      response=401,
   *      description="Unauthenticated",
   *    ),
   *    @OA\Response(
   *      response=403,
   *      description="Forbidden",
   *    ),
   *    @OA\Response(
   *      response=400,
   *      description="Bad Request"
   *    ),
   *    @OA\Response(
   *      response=404,
   *      description="Not Found"
   *    )
   *  )
  */
  public function show($id)
  {
    $period = $this->PeriodManagerService->getPeriod($id);

    if (empty($period)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.PeriodNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    $id = strval($period->id);
    unset($period->id);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $period
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
   * @param  \App\Models\Period  $Period
   * @return \Illuminate\Http\Response
   */
      /**
   *  @OA\Put(
   *    path="/api/periods/{id}",
   *    operationId="putPeriod",
   *    tags={"Periods"},
   * security={{"bearer_token":{}}},
   *    summary="Update period",
   *    description="Update period",
   *
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      required=true,
   *      description="Period id",
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="code",
   *      in="query",
   *      description="Period code",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="year",
   *      in="query",
   *      description="Period year",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   *
   *    @OA\Response(
   *      response=200,
   *      description="Success",
   *      @OA\MediaType(
   *        mediaType="application/json",
   *      )
   *    ),
   *    @OA\Response(
   *      response=401,
   *      description="Unauthenticated",
   *    ),
   *    @OA\Response(
   *      response=403,
   *      description="Forbidden",
   *    ),
   *    @OA\Response(
   *      response=400,
   *      description="Bad Request"
   *    ),
   *    @OA\Response(
   *      response=404,
   *      description="Not Found"
   *    )
   *  )
  */
  public function update(PeriodRequest $request, $data)
  {
    $response = $this->PeriodManagerService->update($request, $data);

    if (!$response['success']) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.createperiod'),
          'detail' => __('base.createperiod')
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
        'attributes' => $response['period']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Period  $Period
   * @return \Illuminate\Http\Response
   */
    /**
   *  @OA\Delete(
   *    path="/api/periods/{id}",
   *    operationId="delete period by id",
   *    tags={"Periods"},
   * security={{"bearer_token":{}}},
   *    summary="Delete period by id",
   *    description="Deletes period by id",
   *
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="Period id",
   *      required=true,
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   *
   *    @OA\Response(
   *      response=200,
   *      description="Success",
   *      @OA\MediaType(
   *        mediaType="application/json",
   *      )
   *    ),
   *    @OA\Response(
   *      response=401,
   *      description="Unauthenticated",
   *    ),
   *    @OA\Response(
   *      response=403,
   *      description="Forbidden",
   *    ),
   *    @OA\Response(
   *      response=400,
   *      description="Bad Request"
   *    ),
   *    @OA\Response(
   *      response=404,
   *      description="Not Found"
   *    )
   *  )
  */
  public function destroy($request)
  {
    $response = $this->PeriodManagerService->delete($request);

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
