<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurriculumRequest;
use Illuminate\Http\Request;
use App\Services\Curriculum\CurriculumManager;

class CurriculumController extends Controller
{
  /**
   * Curriculum Manager Service
   *
   * @var App\Services\CurriculumManager\CurriculumManagementInterface;
   *
   */
  protected $CurriculumManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    CurriculumManager $CurriculumManagerService
  ) {
    $this->CurriculumManagerService = $CurriculumManagerService;
    $this->responseType = 'curricula';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   /** 
   *  @OA\Get(
   *    path="/api/curricula",
   *    operationId="getCurricula",
   *    tags={"Curricula"},
   * security={{"bearer_token":{}}},
   *    summary="Get curricula list",
   *    description="Returns curricula list",
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
    $response = $this->CurriculumManagerService->getTableRowsWithPagination(request()->all());

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
   *    path="/api/curricula",
   *    operationId="postCurricula",
   *    tags={"Curricula"},
   * security={{"bearer_token":{}}},
   *    summary="Create curricula",
   *    description="Create curricula",
   * 
   *    @OA\Parameter(
   *      name="name",
   *      in="query",
   *      description="Curricula name to create",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="year",
   *      in="query",
   *      description="Curricula year",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="is_active",
   *      in="query",
   *      description="Is curricula active?",
   *      required=true,
   *      @OA\Schema(
   *        type="boolean",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="is_approved",
   *      in="query",
   *      description="Is curricula currently approved?",
   *      required=true,
   *      @OA\Schema(
   *        type="boolean",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="career_id",
   *      in="query",
   *      description="Career id",
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
  public function store(CurriculumRequest $request)
  {
    $response = $this->CurriculumManagerService->create($request);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $response['id'],
        'attributes' => $response['curriculum']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Curriculum  $Curriculum
   * @return \Illuminate\Http\Response
   */
  /** 
   *  @OA\Get(
   *    path="/api/curricula/{id}",
   *    operationId="get curricula by id",
   *    tags={"Curricula"},
   * security={{"bearer_token":{}}},
   *    summary="Get curricula by id",
   *    description="Returns curricula by id",
   * 
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="Curricula id",
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
    $curriculum = $this->CurriculumManagerService->getCurriculum($id);

    if (empty($curriculum)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.CurriculumNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    $id = strval($curriculum->id);
    unset($curriculum->id);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $curriculum
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
   * @param  \App\Models\Curriculum  $Curriculum
   * @return \Illuminate\Http\Response
   */
    /** 
   *  @OA\Put(
   *    path="/api/curricula/{id}",
   *    operationId="putCurricula",
   *    tags={"Curricula"},
   * security={{"bearer_token":{}}},
   *    summary="Update curricula",
   *    description="Update curricula",
   * 
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      required=true,
   *      description="Curricula id",
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
   *    @OA\Parameter(
   *      name="year",
   *      in="query",
   *      description="Curricula year",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="is_active",
   *      in="query",
   *      description="Is curricula active?",
   *      required=true,
   *      @OA\Schema(
   *        type="boolean",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="is_approved",
   *      in="query",
   *      description="Is curricula currently approved?",
   *      required=true,
   *      @OA\Schema(
   *        type="boolean",
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
  public function update(CurriculumRequest $request, $data)
  {
    $response = $this->CurriculumManagerService->update($request, $data);

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
        'attributes' => $response['curriculum']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Curriculum  $Curriculum
   * @return \Illuminate\Http\Response
   */
  /** 
   *  @OA\Delete(
   *    path="/api/curricula/{id}",
   *    operationId="delete curricula by id",
   *    tags={"Curricula"},
   * security={{"bearer_token":{}}},
   *    summary="Delete curricula by id",
   *    description="Deletes curricula by id",
   * 
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="Curricula id",
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
    $response = $this->CurriculumManagerService->delete($request);

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
