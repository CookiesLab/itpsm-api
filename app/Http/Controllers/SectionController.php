<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use Illuminate\Http\Request;
use App\Services\Section\SectionManager;

class SectionController extends Controller
{
  /**
   * Section Manager Service
   *
   * @var App\Services\SectionManager\SectionManagementInterface;
   *
   */
  protected $SectionManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    SectionManager $SectionManagerService
  ) {
    $this->SectionManagerService = $SectionManagerService;
    $this->responseType = 'sections';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
     /** 
   *  @OA\Get(
   *    path="/api/sections",
   *    operationId="getSections",
   *    tags={"Sections"},
   * security={{"bearer_token":{}}},
   *    summary="Get section list",
   *    description="Returns section list",
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
    $response = $this->SectionManagerService->getTableRowsWithPagination(request()->all());

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
   *    path="/api/sections",
   *    operationId="postSection",
   *    tags={"Sections"},
   * security={{"bearer_token":{}}},
   *    summary="Create section",
   *    description="Create section",
   * 
   *    @OA\Parameter(
   *      name="quota",
   *      in="query",
   *      description="Section quota",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="schedule",
   *      in="query",
   *      description="Section schedule",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="teacher_id",
   *      in="query",
   *      description="Section teacher id",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="curriculum_subject_id",
   *      in="query",
   *      description="Section curriculum_subject_id",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *   @OA\Parameter(
   *      name="period_id",
   *      in="query",
   *      description="Section period_id",
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
  public function store(SectionRequest $request)
  {
    $response = $this->SectionManagerService->create($request);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $response['id'],
        'attributes' => $response['section']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Section  $Section
   * @return \Illuminate\Http\Response
   */
    /** 
   *  @OA\Get(
   *    path="/api/sections/{code}",
   *    operationId="get section by code",
   *    tags={"Sections"},
   * security={{"bearer_token":{}}},
   *    summary="Get section by id",
   *    description="Returns section by id",
   * 
   *    @OA\Parameter(
   *      name="code",
   *      in="path",
   *      description="Section code",
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
    $section = $this->SectionManagerService->getSection($id);

    if (empty($section)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.SectionNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'attributes' => $section
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
   * @param  \App\Models\Section  $Section
   * @return \Illuminate\Http\Response
   */
      /** 
   *  @OA\Put(
   *    path="/api/sections/{code}",
   *    operationId="putSection",
   *    tags={"Sections"},
   * security={{"bearer_token":{}}},
   *    summary="Update section",
   *    description="Update section",
   * 
   *    @OA\Parameter(
   *      name="code",
   *      in="path",
   *      required=true,
   *      description="Section code",
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   * 
   *    *    @OA\Parameter(
   *      name="quota",
   *      in="query",
   *      description="Section quota",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="schedule",
   *      in="query",
   *      description="Section schedule",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="teacher_id",
   *      in="query",
   *      description="Section teacher id",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="curriculum_subject_id",
   *      in="query",
   *      description="Section curriculum_subject_id",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *   @OA\Parameter(
   *      name="period_id",
   *      in="query",
   *      description="Section period_id",
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
  public function update(SectionRequest $request, $data)
  {
    $response = $this->SectionManagerService->update($request, $data);

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
        'attributes' => $response['section']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Section  $Section
   * @return \Illuminate\Http\Response
   */
    /** 
   *  @OA\Delete(
   *    path="/api/sections/{code}",
   *    operationId="delete section by code",
   *    tags={"Sections"},
   * security={{"bearer_token":{}}},
   *    summary="Delete section by code",
   *    description="Deletes section by code",
   * 
   *    @OA\Parameter(
   *      name="code",
   *      in="path",
   *      description="Section code",
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
    $response = $this->SectionManagerService->delete($request);

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
