<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnrollmentRequest;
use Illuminate\Http\Request;
use App\Services\StudentCurricula\StudentCurriculaManager;
use App\Services\Enrollment\EnrollmentManager;
use App\Services\Period\PeriodManager;
use App\Services\Section\SectionManager;
use Illuminate\Support\Facades\Log;

class EnrollmentController extends Controller
{
  /**
   * Enrollment Manager Service
   *
   * @var App\Services\Enrollment\EnrollmentManagementInterface;
   *
   */
  protected $EnrollmentManagerService;

  /**
   * Enrollment Manager Service
   *
   * @var App\Services\StudentCurricula\StudentCurriculaManagementInterface;
   *
   */
  protected $StudentCurriculaManagerService;

  /**
   * Enrollment Manager Service
   *
   * @var App\Services\Period\PeriodManagementInterface;
   *
   */
  protected $PeriodManagerService;

  /**
   * Enrollment Manager Service
   *
   * @var App\Services\Section\SectionManagementInterface;
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
    EnrollmentManager $EnrollmentManagerService,
    StudentCurriculaManager $StudentCurriculaManagerService,
    PeriodManager $PeriodManagerService,
    SectionManager $SectionManagerService,
  ) {
    $this->EnrollmentManagerService = $EnrollmentManagerService;
    $this->StudentCurriculaManagerService = $StudentCurriculaManagerService;
    $this->PeriodManagerService = $PeriodManagerService;
    $this->SectionManagerService = $SectionManagerService;
    $this->responseType = 'enrollments';
  }
/**
   * Get subjects to be enrolled in the active period
   *
   * @return \Illuminate\Http\Response
   */
     /**
   *  @OA\Get(
   *    path="/api/enrollment/active-subjects",
   *    operationId="getEnrollmentstomake",
   *    tags={"Enrollments"},
   * security={{"bearer_token":{}}},
   *    summary=" Get subjects to be enrolled in the active period filter by level and student curricula ",
   *    description=" Get subjects to be enrolled in the active period  by level and student curricula",
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
  public function getSubjectsToBeEnrolled(Request $request)
  {
    $loggedUser = $request->user();
    $studentId = $loggedUser->system_reference_id;

    $errorMessage = '';
    $currentPeriod = $this->PeriodManagerService->getCurrentEnrollmentPeriod();
    $currentCurricula = $this->StudentCurriculaManagerService->getActiveCurriculaByStudentId($studentId);
    Log::emergency($currentCurricula);
    if (empty($currentPeriod)) {
      $errorMessage = 'No hay un ciclo de estudio para inscribir';
    }

    if (empty($currentCurricula)) {
      $errorMessage = 'No tienes un plan de estudio activo';
    }

    if (!empty($errorMessage)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => $errorMessage,
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    $rows = [];
    $curriculumSubjectsApproved = $this->EnrollmentManagerService->getCurriculumSubjectsApproved($studentId);
    $currentEnrolled = $this->EnrollmentManagerService->getCurrentEnrolled($studentId, $currentPeriod->id);
    foreach ($currentCurricula as $Curricula) {
      
    
    $this->SectionManagerService->getByCurriculumIdAndLevel($currentPeriod->id, $Curricula->curriculum_id, $Curricula->level)->each(function ($section) use (&$rows, &$curriculumSubjectsApproved, &$currentEnrolled) {
      $isCurriculumSubjectApproved = $curriculumSubjectsApproved->search(function ($item) use (&$section) {
        return $item->curriculum_subject_id == $section->curriculum_subject_id;
      });

      $isCurrentEnrolled = $currentEnrolled->search(function ($item2) use (&$section) {
        return $item2->curriculum_subject_id == $section->curriculum_subject_id;
      });

      if (is_numeric($isCurriculumSubjectApproved) || is_numeric($isCurrentEnrolled)) {
        return;
      }

      // TODO: Consultar horarios y validar prerequisitos;
      array_push($rows, $section);
    });
  }
    return response()->json([
      'meta' => [
      ],
      'data' => [
        'id' => $studentId,
        'rows' => $rows,
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }
/**
   * enroll subjects to the active period
   *
   * @return \Illuminate\Http\Response
   */
     /**
   *  @OA\Post(
   *    path="/api/enrollment/enroll-subjects",
   *    operationId="Enrollmentsmake",
   *    tags={"Enrollments"},
   * security={{"bearer_token":{}}},
   *    summary="enroll subjects to the active period",
   *    description="enroll subjects to the active period",
   *
   *  @OA\Parameter(
   *      name="Subjects",
   *      in="query",
   *      description="Subjects to be enrolled",
   *      required=true,
   *      @OA\Schema(
   *        type="array",
   *        @OA\Items(   @OA\Property(
 *                         property="firstName",
 *                         type="string",
 *                         example=""
 *                      ),
 *                      @OA\Property(
 *                         property="lastName",
 *                         type="string",
 *                         example=""
 *                      ),
 *                      @OA\Property(
 *                         property="companyId",
 *                         type="string",
 *                         example=""
 *                      ),
 *                      @OA\Property(
 *                         property="accountNumber",
 *                         type="number",
 *                         example=""
 *                      ),
 *                      @OA\Property(
 *                         property="netPay",
 *                         type="money",
 *                         example=""
 *                      ),
 * )
*              
   *      )
   *    ),
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
  public function enrollSubjects(Request $request)
  {
    $id_schedule=[];
    foreach ($request->subjects as $subject) {
      array_push($id_schedule,$subject['id_schedule']);
    }

    $esigual =count($id_schedule)===count(array_unique($id_schedule));
    
    $loggedUser = $request->user();
    $studentId = $loggedUser->system_reference_id;

    $enrolled = $notEnrolled = [];

    if($esigual){
      foreach ($request->subjects as $subject) {
        // TODO: Verificar cupos disponibles
        $subject['student_id'] = $studentId;
        // TODO: Verificar la matricula
        $subject['enrollment'] = 1;
        $response = $this->EnrollmentManagerService->create($subject);
  
        if ($response['success']) {
          array_push($enrolled, $response['enrollment']);
        }
        else {
          array_push($notEnrolled, $subject);
        }
    }
  
      return response()->json([
        'data' => [
          'type' => $this->responseType,
          'enrolled' => $enrolled,
          'notEnrolled' => $notEnrolled,
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 201);
    }
    

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'enrolled' => $enrolled,
        'notEnrolled' => $request->subjects,
        'error'=>'No se pueden inscribir materias en el mismo horario'
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }

/**
   * Get subjects enrolled for the active period
   *
   * @return \Illuminate\Http\Response
   */
     /**
   *  @OA\Get(
   *    path="/api/enrollment/enrolled-curriculum-subjects",
   *    operationId="getEnrollmentsmade",
   *    tags={"Enrollments"},
   * security={{"bearer_token":{}}},
   *    summary=" Get subjects enrolled for the active period",
   *    description=" Get subjects enrolled for the active period",
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
  public function getEnrolledCurriculumSubjects(Request $request)
  {
    $loggedUser = $request->user();
    $studentId = $loggedUser->system_reference_id;

    $currentPeriod = $this->PeriodManagerService->getCurrentEnrollmentPeriod();
    if (empty($currentPeriod)) {
      $errorMessage = 'No hay un ciclo de estudio para inscribir';
    }
    if (!empty($errorMessage)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => $errorMessage,
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }
    $currentEnrolled = $this->EnrollmentManagerService->getCurrentEnrolled($studentId, $currentPeriod->id);

    return response()->json([
      'meta' => [
        'page' => 1,
        'totalPages' => 1,
        'records' => $currentEnrolled->count(),
        'period' => $currentPeriod,
      ],
      'data' => $currentEnrolled->toArray(),
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }
 /**
   * Get subjects for academic history
   *
   * @return \Illuminate\Http\Response
   */
     /**
   *  @OA\Get(
   *    path="/api/enrollment/approved-subjects",
   *    operationId="getEnrollmentsforhistory",
   *    tags={"Enrollments"},
   * security={{"bearer_token":{}}},
   *    summary=" Get subjects for academic history",
   *    description=" Get subjects for academic history",
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
  public function getApprovedCurriculumSubjects(Request $request)
  {
    $loggedUser = $request->user();
    $studentId = $loggedUser->system_reference_id;

    $response = $this->EnrollmentManagerService->getCurriculumSubjectsApproved($studentId);

    return response()->json([
      'meta' => [
        'page' => 1,
        'totalPages' => 1,
        'records' => $response->count(),
      ],
      'data' => $response->toArray(),
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
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
   *      description="0 false, 1 true",
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
    $response = $this->EnrollmentManagerService->create($request->all());

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
   *      description="0 false, 1 true",
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
