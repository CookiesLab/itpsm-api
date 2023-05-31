<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademicHistoryRequest;
use Illuminate\Http\Request;
use App\Services\AcademicHistory\AcademicHistoryManager;

class AcademicHistoryController extends Controller
{
  /**
   * Curriculum Manager Service
   *
   * @var App\Services\AcademicHistoryManager\AcademicHistoryManagementInterface;
   *
   */
  protected $AcademicHistoryManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    AcademicHistoryManager $AcademicHistoryManagerService
  ) {
    $this->AcademicHistoryManagerService = $AcademicHistoryManagerService;
    $this->responseType = 'curricula';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   /**
   *  @OA\Get(
   *    path="/api/AcademicHistory",
   *    operationId="getCurricula",
   *    tags={"AcademicHistory"},
   * security={{"bearer_token":{}}},
   *    summary="Get AcademicHistory list",
   *    description="Returns AcademicHistory list",
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
    $response = $this->AcademicHistoryManagerService->getTableRowsWithPagination(request()->all());

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


  public function store(AcademicHistoryRequest $request)
  {
    $response = $this->AcademicHistoryManagerService->create($request);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $response['id'],
        'attributes' => $response['academicHistory']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }


  public function show($id)
  {
    $AcademicHistory = $this->AcademicHistoryManagerService->getCurriculum($id);

    if (empty($AcademicHistory)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.academicHistoryNotFound'),
          'detail' => __('base.failure')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

//    $id = strval($curriculum->id);
//    unset($curriculum->id);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $AcademicHistory
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }


  public function update(CurriculumRequest $request, $data)
  {
    $response = $this->AcademicHistoryManagerService->update($request, $data);

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
        'attributes' => $response['AcademicHistory']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }


  public function destroy($request)
  {
    $response = $this->AcademicHistoryManagerService->delete($request);

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
