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
     /** 
   *  @OA\Get(
   *    path="/api/scholarships",
   *    operationId="getScholarships",
   *    tags={"Scholarships"},
   * security={{"bearer_token":{}}},
   *    summary="Get scholarship list",
   *    description="Returns scholarship list",
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
     /** 
   *  @OA\Post(
   *    path="/api/scholarships",
   *    operationId="postScholarship",
   *    tags={"Scholarships"},
   * security={{"bearer_token":{}}},
   *    summary="Create Scholarship",
   *    description="Create Scholarship",
   * 
   *    @OA\Parameter(
   *      name="name",
   *      in="query",
   *      description="Scholarship name",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="scholarship_foundation",
   *      in="query",
   *      description="Scholarship foundation",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *      )
   *    ),
   * 
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
    /** 
   *  @OA\Get(
   *    path="/api/scholarships/{id}",
   *    operationId="get scholarship by id",
   *    tags={"Scholarships"},
   * security={{"bearer_token":{}}},
   *    summary="Get scholarship by id",
   *    description="Returns scholarship by id",
   * 
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="Scholarship id",
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
      /** 
   *  @OA\Put(
   *    path="/api/scholarships/{id}",
   *    operationId="putScholarship",
   *    tags={"Scholarships"},
   * security={{"bearer_token":{}}},
   *    summary="Update Scholarship",
   *    description="Update Scholarship",
   * 
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      required=true,
   *      description="Scholarship id",
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="name",
   *      in="query",
   *      required=true,
   *      description="Scholarship name",
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="scholarship_foundation",
   *      in="query",
   *      description="Scholarship foundation",
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
    /** 
   *  @OA\Delete(
   *    path="/api/scholarships/{id}",
   *    operationId="delete scholarships by id",
   *    tags={"Scholarships"},
   * security={{"bearer_token":{}}},
   *    summary="Delete scholarship by id",
   *    description="Deletes scholarship by id",
   * 
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="Scholarship id",
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
