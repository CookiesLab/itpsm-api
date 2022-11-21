<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use Illuminate\Http\Request;
use App\Services\Teacher\TeacherManager;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
class TeacherController extends Controller
{
  /**
   * Teacher Manager Service
   *
   * @var App\Services\TeacherManager\TeacherManagementInterface;
   *
   */
  protected $TeacherManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    TeacherManager $TeacherManagerService
  ) {
    $this->TeacherManagerService = $TeacherManagerService;
    $this->responseType = 'teachers';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  /**
   *  @OA\Get(
   *    path="/api/teachers",
   *    operationId="getTeachers",
   *    tags={"Teachers"},
   * security={{"bearer_token":{}}},
   *    summary="Get list of teachers",
   *    description="Returns list of teachers",
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
    $response = $this->TeacherManagerService->getTableRowsWithPagination(request()->all());

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
   *    path="/api/teachers",
   *    operationId="postTeachers",
   *    tags={"Teachers"},
   * security={{"bearer_token":{}}},
   *    summary="Create teachers",
   *    description="Create teachers",
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
   *      name="nit",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="dui",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="isss_number",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="nup_number",
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
   *      name="genre",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *        minLength= 1,
   *        maxLength= 1
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
   *    @OA\Parameter(
   *      name="status_id",
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
  public function store(TeacherRequest $request)
  {
    $response = $this->TeacherManagerService->create($request);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $response['id'],
        'attributes' => $response['teacher']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Teacher  $Teacher
   * @return \Illuminate\Http\Response
   */
   /**
   *  @OA\Get(
   *    path="/api/teachers/{id}",
   *    operationId="get teacher by id",
   *    tags={"Teachers"},
   * security={{"bearer_token":{}}},
   *    summary="Get teacher by id",
   *    description="Returns teacher by id",
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
    $teacher = $this->TeacherManagerService->getTeacher($id);

    if (empty($teacher)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.TeacherNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    $id = strval($teacher->id);
    unset($teacher->id);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $teacher
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
   * @param  \App\Models\Teacher  $Teacher
   * @return \Illuminate\Http\Response
   */
      /**
   *  @OA\Put(
   *    path="/api/teachers/{id}",
   *    operationId="putTeachers",
   *    tags={"Teachers"},
   * security={{"bearer_token":{}}},
   *    summary="Update teachers",
   *    description="Update teachers",
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
   *      name="nit",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="dui",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="isss_number",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="nup_number",
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
   *      name="genre",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *        minLength= 1,
   *        maxLength= 1
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
   *    @OA\Parameter(
   *      name="status_id",
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
  public function update(TeacherRequest $request, $data)
  {
    $response = $this->TeacherManagerService->update($request, $data);

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
        'attributes' => $response['teacher']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Teacher  $Teacher
   * @return \Illuminate\Http\Response
   */
   /**
   *  @OA\Delete(
   *    path="/api/teachers/{id}",
   *    operationId="delete teacher by id",
   *    tags={"Teachers"},
   * security={{"bearer_token":{}}},
   *    summary="Delete teacher by id",
   *    description="Delete teacher by id",
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
   
    $response = $this->TeacherManagerService->delete($request);

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
   *
   *
   * @param \App\Models\Teacher $Teacher
   * @return \Illuminate\Http\Response
   */
  /**
   * @OA\Post(
   *    path="/api/teachers/generate-system-users",
   *    operationId="Generate users for teachers witout users",
   *    tags={"Teachers"},
   * security={{"bearer_token":{}}},
   *    summary="Generate users for teachers witout users",
   *    description="Generate users for teachers witout users",
   *    @OA\Response(
   *      response=200,
   *      description="Success",
   *      @OA\MediaType(
   *        mediaType="application/pdf",
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
  public function generateSystemUsers(Request $request)
  {
    return $this->TeacherManagerService->generateSystemUsers();
  }
  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Teacher  $Teacher
   * @return \Illuminate\Http\Response
   */
   /**
   *  @OA\Get(
   *    path="/api/teachers/sections",
   *    operationId="get teacher sections by id",
   *    tags={"Teachers"},
   * security={{"bearer_token":{}}},
   *    summary="Get teacher sections by id",
   *    description="Returns teacher sections by id",
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


  public function getSections()
  {
    
    $response = $this->TeacherManagerService->getTableRowsWithPaginationSection(request()->all());




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
   * Display the specified resource.
   *
   * @param  \App\Models\Teacher  $Teacher
   * @return \Illuminate\Http\Response
   */
   /**
   *  @OA\Get(
   *    path="/api/teachers/all",
   *    operationId="Get all teachers ",
   *    tags={"Teachers"},
   * security={{"bearer_token":{}}},
   *    summary="Get all teachers ",
   *    description="Get all teachers ",
   *
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
  public function allTeachers()
  {
    $teacher = $this->TeacherManagerService->getTeachers();

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'attributes' => $teacher
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }
}
