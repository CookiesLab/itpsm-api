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
  /** 
   *  @OA\Get(
   *    path="/api/careers",
   *    operationId="getCareers",
   *    tags={"Careers"},
   * security={{"bearer_token":{}}},
   *    summary="Get career list",
   *    description="Returns career list",
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
   /** 
   *  @OA\Post(
   *    path="/api/careers",
   *    operationId="postCareers",
   *    tags={"Careers"},
   * security={{"bearer_token":{}}},
   *    summary="Create career",
   *    description="Create career",
   * 
   *    @OA\Parameter(
   *      name="name",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
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
   /** 
   *  @OA\Get(
   *    path="/api/careers/{id}",
   *    operationId="get career by id",
   *    tags={"Careers"},
   * security={{"bearer_token":{}}},
   *    summary="Get career by id",
   *    description="Returns career by id",
   * 
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
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
     /** 
   *  @OA\Put(
   *    path="/api/careers/{id}",
   *    operationId="putCareers",
   *    tags={"Careers"},
   * security={{"bearer_token":{}}},
   *    summary="Update career",
   *    description="Update career",
   * 
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      required=true,
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="name",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
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
     /** 
   *  @OA\Delete(
   *    path="/api/careers/{id}",
   *    operationId="delete career by id",
   *    tags={"Careers"},
   * security={{"bearer_token":{}}},
   *    summary="Delete career by id",
   *    description="Delete career by id",
   * 
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
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
