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
     /** 
   *  @OA\Get(
   *    path="/api/enrollments",
   *    operationId="getEnrollments",
   *    tags={"Enrollments"},
   * security={{"bearer_token":{}}},
   *    summary="Get enrollments list",
   *    description="Returns enrollments list",
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
     /** 
   *  @OA\Post(
   *    path="/api/enrollments",
   *    operationId="postEnrollments",
   *    tags={"Enrollments"},
   * security={{"bearer_token":{}}},
   *    summary="Create enrollment",
   *    description="Create enrollment",
   * 
   *    @OA\Parameter(
   *      name="final_score",
   *      in="query",
   *      description="Enrollment final score",
   *      required=true,
   *      @OA\Schema(
   *        type="number",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="is_approved",
   *      in="query",
   *      description="Is tehe enrollment approved",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *        minimum=0,
   *        maximum=1
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="enrollment",
   *      in="query",
   *      description="Enrollment",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="curriculum_subject_id",
   *      in="query",
   *      description="curriculum_subject_id",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="period_id",
   *      in="query",
   *      description="period id",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="code",
   *      in="query",
   *      description="section code",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *   *    @OA\Parameter(
   *      name="student_id",
   *      in="query",
   *      description="student id",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   *   *    @OA\Parameter(
   *      name="teacher_id",
   *      in="query",
   *      description="teacher_id",
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
    /** 
   *  @OA\Get(
   *    path="/api/enrollments/{id}",
   *    operationId="get enrollment by id",
   *    tags={"Enrollments"},
   * security={{"bearer_token":{}}},
   *    summary="Get enrollment by id",
   *    description="Returns enrollment by id",
   * 
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="Enrollment id",
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
   * */
  /** 
   *  @OA\Put(
   *    path="/api/enrollments/{id}",
   *    operationId="putEnrollment",
   *    tags={"Enrollments"},
   * security={{"bearer_token":{}}},
   *    summary="Update enrollment",
   *    description="Update enrollment",
   * 
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      required=true,
   *      description="enrollment id",
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   * 
 *    @OA\Parameter(
   *      name="final_score",
   *      in="query",
   *      description="Enrollment final score",
   *      required=true,
   *      @OA\Schema(
   *        type="number",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="is_approved",
   *      in="query",
   *      description="Is tehe enrollment approved",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *        minimum=0,
   *        maximum=1
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="enrollment",
   *      in="query",
   *      description="Enrollment",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="curriculum_subject_id",
   *      in="query",
   *      description="curriculum_subject_id",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="period_id",
   *      in="query",
   *      description="period id",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="code",
   *      in="query",
   *      description="section code",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   * 
   *   *    @OA\Parameter(
   *      name="student_id",
   *      in="query",
   *      description="student id",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   *   *    @OA\Parameter(
   *      name="teacher_id",
   *      in="query",
   *      description="teacher_id",
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
    /** 
   *  @OA\Delete(
   *    path="/api/enrollments/{id}",
   *    operationId="delete Enrollment by id",
   *    tags={"Enrollments"},
   * security={{"bearer_token":{}}},
   *    summary="Delete Enrollment by id",
   *    description="Deletes Enrollment by id",
   * 
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="Enrollment id",
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
