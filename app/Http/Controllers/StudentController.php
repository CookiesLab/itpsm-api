<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Services\Student\StudentManager;
use Illuminate\Http\Request;

class StudentController extends Controller
{
  /**
   * Student Manager Service
   *
   * @var App\Services\StudentManager\StudentManagementInterface;
   *
   */
  protected $StudentManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    StudentManager $StudentManagerService
  )
  {
    $this->StudentManagerService = $StudentManagerService;
    $this->responseType = 'students';
    $this->middleware('role:Super Admin|permission:leer estudiantes',['only'=>'index']);
    $this->middleware('role:Super Admin|permission:crear estudiantes',['only'=>'store']);
    $this->middleware('role:Super Admin|permission:leer estudiante',['only'=>'show']);
    $this->middleware('role:Super Admin|permission:editar estudiante',['only'=>'update']);
    $this->middleware('role:Super Admin|permission:borrar estudiantes',['only'=>'destroy']);

  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  /**
   * @OA\Get(
   *    path="/api/students",
   *    operationId="getStudents",
   *    tags={"Students"},
   * security={{"bearer_token":{}}},
   *    summary="Get list of students",
   *    description="Returns list of students",
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
    $response = $this->StudentManagerService->getTableRowsWithPagination(request()->all());

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

    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  /**
   * @OA\Post(
   *    path="/api/students",
   *    operationId="postStudents",
   *    tags={"Students"},
   * security={{"bearer_token":{}}},
   *    summary="Create student",
   *    description="Create student",
   *
   * @OA\Parameter(
   *      name="carnet",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
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
   *      name="last_name",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="email",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="birth_date",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *        format="date"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="address",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="phone_number",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="home_phone_number",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="gender",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *        minLength=1,
   *        maxLength=1
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="relationship",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *        minLength=1,
   *        maxLength=1
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="status",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *        minLength=1,
   *        maxLength=1
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="blood_type",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="mother_name",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="mother_phone_number",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="father_name",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="father_phone_number",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string",
   *        maxLength=15
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="emergency_contact_name",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="emergency_contact_phone",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string",
   *        maxLength=15
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="diseases",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="allergies",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="medicines",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="entry_date",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="entry_period",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="date_high_school_degree",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="municipality_id",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="department_id",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="country_id",
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
  public function store(StudentRequest $request)
  {
    $user= $request->user()->getRoleNames();
    $response = $this->StudentManagerService->create($request);


    if (!$response['success']) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => $response['message'],
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
        'attributes' => $response['student']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param \App\Models\Student $Student
   * @return \Illuminate\Http\Response
   */
  /**
   * @OA\Get(
   *    path="/api/students/{id}",
   *    operationId="get student by id",
   *    tags={"Students"},
   * security={{"bearer_token":{}}},
   *    summary="Get student by id",
   *    description="Returns student by id",
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
    $student = $this->StudentManagerService->getStudent($id);

    if (empty($student)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.StudentNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    $id = strval($student->id);
    unset($student->id);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $student
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Student $Student
   * @return \Illuminate\Http\Response
   */
  /**
   * @OA\Put(
   *    path="/api/students/{id}",
   *    operationId="putStudents",
   *    tags={"Students"},
   * security={{"bearer_token":{}}},
   *    summary="Update student",
   *    description="Update student",
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
   *      name="carnet",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
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
   *      name="last_name",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="email",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="institutional_email",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="birth_date",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *        format="date"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="address",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="phone_number",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="home_phone_number",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="gender",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *        minLength=1,
   *        maxLength=1
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="relationship",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *        minLength=1,
   *        maxLength=1
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="status",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *        minLength=1,
   *        maxLength=1
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="blood_type",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="mother_name",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="mother_phone_number",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="father_name",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="father_phone_number",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string",
   *        maxLength=15
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="emergency_contact_name",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="emergency_contact_phone",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string",
   *        maxLength=15
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="diseases",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="allergies",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="medicines",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="entry_date",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="entry_period",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="date_high_school_degree",
   *      in="query",
   *      required=false,
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="municipality_id",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="department_id",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="country_id",
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
  public function update(StudentRequest $request, $data)
  {
    $response = $this->StudentManagerService->update($request, $data);

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
        'attributes' => $response['student']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Models\Student $Student
   * @return \Illuminate\Http\Response
   */
  /**
   * @OA\Delete(
   *    path="/api/students/{id}",
   *    operationId="delete student by id",
   *    tags={"Students"},
   * security={{"bearer_token":{}}},
   *    summary="Delete student by id",
   *    description="Deletes student by id",
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
    $response = $this->StudentManagerService->delete($request);

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

  public function createDefaultPdf(Request $request)
  {
    $studentId = $request->input('id');
    return $this->StudentManagerService->createDefaultPdf($studentId);
  }

  public function generateSystemUsers(Request $request)
  {
    return $this->StudentManagerService->generateSystemUsers();
  }
}
