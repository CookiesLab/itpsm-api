<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentCurriculaRequest;
use Illuminate\Http\Request;
use App\Services\StudentCurricula\StudentCurriculaManager;
use App\Services\Curriculum\Curriculum;
use Illuminate\Support\Facades\Log;


class StudentCurriculaController extends Controller
{
  /**
   * StudentCurricula Manager Service
   *
   * @var App\Services\StudentCurriculaManager\StudentCurriculaManagementInterface;
   *
   */
  protected $StudentCurriculaManagerService;
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
    StudentCurriculaManager $StudentCurriculaManagerService
  ) {
    $this->StudentCurriculaManagerService = $StudentCurriculaManagerService;
    $this->responseType = 'student_curricula';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
       /**
   *  @OA\Get(
   *    path="/api/student-curricula",
   *    operationId="get student-curricula",
   *    tags={"Enroll student to curricula"},
   * security={{"bearer_token":{}}},
   *    summary="Get student-curricula",
   *    description="Returns student-curricula and allows to filter by student id or curriculum id ",
   *
   *    @OA\Parameter(
   *      name="query",
   *      in="query",
   *      description="query format like:{""query"":[{""field"":""cs.student_id"",""op"":""="",""data"":""2""}]}",
   *      required=false,
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
  public function index()
  {
    $response = $this->StudentCurriculaManagerService->getTableRowsWithPagination(request()->all());

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
   *    path="/api/student-curricula",
   *    operationId="postStudent-curricula",
   *    tags={"Enroll student to curricula"},
   * security={{"bearer_token":{}}},
   *    summary="Enroll student to curricula",
   *    description="Enroll student to curricula",
   *
   * @OA\Parameter(
   *      name="cum",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="number"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="entry_year",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="graduation_year",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string",
   *        format="date",
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="scholarship_rate",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="student_id",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="curriculum_id",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="scholarship_id",
   *      in="query",
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
  public function store(StudentCurriculaRequest $request)
  {
    $response = $this->StudentCurriculaManagerService->create($request);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $response['id'],
        'attributes' => $response['student_curricula']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\StudentCurricula  $StudentCurricula
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $studentCurricula = $this->StudentCurriculaManagerService->getStudentCurricula($id);

    if (empty($studentCurricula)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.StudentCurriculaNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'attributes' => $studentCurricula
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
   * @param  \App\Models\StudentCurricula  $StudentCurricula
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(StudentCurriculaRequest $request, $data)
  {
    $response = $this->StudentCurriculaManagerService->update($request, $data);

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
        'attributes' => $response['student_curricula']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\StudentCurricula  $StudentCurricula
   * @return \Illuminate\Http\Response
   */
  public function destroy($request)
  {
    $response = $this->StudentCurriculaManagerService->delete($request);

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

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\StudentCurricula  $StudentCurricula
   * @return \Illuminate\Http\JsonResponse
   */
  public function showbystudentid($id)
  {
    $studentCurricula = $this->StudentCurriculaManagerService->getStudentCurriculabyStudentid($id);
    $studentcoll= $studentCurricula->first();

    Log::Emergency($studentcoll->curriculum_id);
    $curriculum=$this->CurriculumManagerService->getCurriculum($studentcoll->curriculum_id);
//    Log::Emergency($studentCurricula[0]['curriculum_id']);

    if (empty($studentCurricula)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.StudentCurriculaNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }


    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'attributes' => $studentCurricula
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }
}


