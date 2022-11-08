<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use App\Http\Requests\TeacherRequest;
use Illuminate\Http\Request;
use App\Services\User\UserManager;

class UserController extends Controller
{
  /**
   * Teacher Manager Service
   *
   * @var App\Services\UserManager\UserManagementInterface;
   *
   */
  protected $UserManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    UserManager $UserManagerService
  ) {
    $this->UserManagerService = $UserManagerService;
    $this->responseType = 'users';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  /**
   *  @OA\Get(
   *    path="/api/users",
   *    operationId="getUsers",
   *    tags={"Users"},
   * security={{"bearer_token":{}}},
   *    summary="Get list of users",
   *    description="Returns list of users",
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
    $response = $this->UserManagerService->getTableRowsWithPagination(request()->all());

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
   *    path="/api/users",
   *    operationId="postUsers",
   *    tags={"Users"},
   * security={{"bearer_token":{}}},
   *    summary="Create users",
   *    description="Create users",
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
   *      name="email",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   *      @OA\Parameter(
   *      name="password",
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
  public function store(UserRequest $request)
  {
    $response = $this->UserManagerService->create($request);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $response['id'],
        'attributes' => $response['user']
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
   * 
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
   *    path="/api/users/{id}",
   *    operationId="putUsers",
   *    tags={"Users"},
   * security={{"bearer_token":{}}},
   *    summary="Update teachers",
   *    description="Update teachers",
   *
   *   @OA\Parameter(
   *      name="name",
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
   *      @OA\Parameter(
   *      name="password",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
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
  public function update(UserRequest $request, $data)
  {
    $response = $this->UserManagerService->update($request, $data);

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
        'attributes' => $response['user']
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
   * 
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

}
