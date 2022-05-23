<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurriculumSubjectRequest;
use Illuminate\Http\Request;
use App\Services\CurriculumSubject\CurriculumSubjectManager;

class CurriculumSubjectController extends Controller
{
  /**
   * CurriculumSubject Manager Service
   *
   * @var App\Services\CurriculumSubjectManager\CurriculumSubjectManagementInterface;
   *
   */
  protected $CurriculumSubjectManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    CurriculumSubjectManager $CurriculumSubjectManagerService
  ) {
    $this->CurriculumSubjectManagerService = $CurriculumSubjectManagerService;
    $this->responseType = 'curriculumSubjects';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function index()
  {
    $response = $this->CurriculumSubjectManagerService->getTableRowsWithPagination(request()->all());

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
   *    path="/api/curriculum-subjects",
   *    operationId="postCurriculum-subjects",
   *    tags={"Curriculum subjects"},
   * security={{"bearer_token":{}}},
   *    summary="Create curriculum-subjects",
   *    description="Create curriculum-subjects",
   * 
   *    @OA\Parameter(
   *      name="uv",
   *      in="query",
   *      description="Curriculum subject UV",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="curriculum_id",
   *      in="query",
   *      description="Curricula id",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="subject_id",
   *      in="query",
   *      description="Subject id associated with the curriculum",
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
  public function store(CurriculumSubjectRequest $request)
  {
    $response = $this->CurriculumSubjectManagerService->create($request);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $response['id'],
        'attributes' => $response['curriculumSubject']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\CurriculumSubject  $CurriculumSubject
   * @return \Illuminate\Http\Response
   */
    /** 
   *  @OA\Get(
   *    path="/api/curriculum-subjects",
   *    operationId="get curriculum-subjects by id",
   *    tags={"Curriculum subjects"},
   * security={{"bearer_token":{}}},
   *    summary="Get curriculum-subjects by id",
   *    description="Returns curriculum-subjects by id",
   * 
   *    @OA\Parameter(
   *      name="query",
   *      in="query",
   *      description="curriculum-subjects id",
   *      required=true,
   *      @OA\MediaType(
   *        mediaType="application/json",
   *  
   *        @OA\Schema(
   *          type="object",
   *          @OA\Property(property="field",  type="string"),
   *          @OA\Property(property="op",  type="string"),
   *          @OA\Property(property="data",  type="string"),
   *        )
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
    $curriculumSubject = $this->CurriculumSubjectManagerService->getCurriculumSubject($id);

    if (empty($curriculumSubject)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.CurriculumSubjectNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    $id = strval($curriculumSubject->id);
    unset($curriculumSubject->id);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $curriculumSubject
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
   * @param  \App\Models\CurriculumSubject  $CurriculumSubject
   * @return \Illuminate\Http\Response
   */
     /** 
   *  @OA\Put(
   *    path="/api/curriculum-subjects/{id}",
   *    operationId="putCurriculum-subjects",
   *    tags={"Curriculum subjects"},
   * security={{"bearer_token":{}}},
   *    summary="Update curriculum-subjects",
   *    description="Update curriculum-subjects",
   * 
   *   @OA\Parameter(
   *      name="id",
   *      in="path",
   *      required=true,
   *      description="Curriculum subject id",
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="uv",
   *      in="query",
   *      description="Curriculum subject UV",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="curriculum_id",
   *      in="query",
   *      description="Curricula id",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="subject_id",
   *      in="query",
   *      description="Subject id associated with the curriculum",
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
  public function update(CurriculumSubjectRequest $request, $data)
  {
    $response = $this->CurriculumSubjectManagerService->update($request, $data);

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
        'attributes' => $response['curriculumSubject']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\CurriculumSubject  $CurriculumSubject
   * @return \Illuminate\Http\Response
   */
      /** 
   *  @OA\Delete(
   *    path="/api/curriculum-subjects/{id}",
   *    operationId="Delete curriculum-subjects by id",
   *    tags={"Curriculum subjects"},
   * security={{"bearer_token":{}}},
   *    summary="Delete curriculum-subjects by id",
   *    description="Delete curriculum-subjects by id",
   * 
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="curriculum-subjects id",
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
    $response = $this->CurriculumSubjectManagerService->delete($request);

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
