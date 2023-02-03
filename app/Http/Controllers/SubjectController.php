<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use Illuminate\Http\Request;
use App\Services\Subject\SubjectManager;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{
  /**
   * Subject Manager Service
   *
   * @var App\Services\SubjectManager\SubjectManagementInterface;
   *
   */
  protected $SubjectManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    SubjectManager $SubjectManagerService
  ) {
    $this->SubjectManagerService = $SubjectManagerService;
    $this->responseType = 'subjects';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
     /** 
   *  @OA\Get(
   *    path="/api/subjects",
   *    operationId="getSubjects",
   *    tags={"Subjects"},
   * security={{"bearer_token":{}}},
   *    summary="Get subjects list",
   *    description="Returns subjects list",
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
    $response = $this->SubjectManagerService->getTableRowsWithPagination(request()->all());

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
   *    path="/api/subjects",
   *    operationId="postSubjects",
   *    tags={"Subjects"},
   * security={{"bearer_token":{}}},
   *    summary="Create subjects",
   *    description="Create subjects",
   * 
   *    @OA\Parameter(
   *      name="name",
   *      in="query",
   *      description="Subject name",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="code",
   *      in="query",
   *      description="Subject code",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
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
  public function store(SubjectRequest $request)
  {
    $response = []; $httpCode = 201;
    $subject = $this->SubjectManagerService->getSubjectByCode($request['code']);

    if(empty($subject)) {
      $newSubject = $this->SubjectManagerService->create($request);
      $response = [
        'data' => [
          'type' => $this->responseType,
          'id' => $newSubject['id'],
          'attributes' => $newSubject['subject']
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ];
    }
    else {
      $httpCode = 200;
      $response = [
        'data' => [ 
          'errors' => [
            'status' => $httpCode,
            'title' => 'Ya existe un módulo con el código ' . $request["code"]
          ],
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ];
    }

    return response()->json($response, $httpCode);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Subject  $Subject
   * @return \Illuminate\Http\Response
   */
    /** 
   *  @OA\Get(
   *    path="/api/subjects/{id}",
   *    operationId="get subjects by id",
   *    tags={"Subjects"},
   * security={{"bearer_token":{}}},
   *    summary="Get subject by id",
   *    description="Returns subject by id",
   * 
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="Subject id",
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
    $subject = $this->SubjectManagerService->getSubject($id);

    if (empty($subject)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.SubjectNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    $id = strval($subject->id);
    unset($subject->id);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $subject
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
   * @param  \App\Models\Subject  $Subject
   * @return \Illuminate\Http\Response
   */
        /** 
   *  @OA\Put(
   *    path="/api/subjects/{id}",
   *    operationId="putSubjects",
   *    tags={"Subjects"},
   * security={{"bearer_token":{}}},
   *    summary="Update subject",
   *    description="Update subject",
   * 
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      required=true,
   *      description="Subject id",
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="name",
   *      in="query",
   *      description="Subject name",
   *      required=true,
   *      @OA\Schema(
   *        type="string"
   *      )
   *    ),
   * 
   *    @OA\Parameter(
   *      name="code",
   *      in="query",
   *      description="Subject code",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
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
  public function update(SubjectRequest $request, $data)
  {
    $response = $this->SubjectManagerService->update($request, $data);

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
        'attributes' => $response['subject']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Subject  $Subject
   * @return \Illuminate\Http\Response
   */
    /** 
   *  @OA\Delete(
   *    path="/api/subjects/{id}",
   *    operationId="delete subject by id",
   *    tags={"Subjects"},
   * security={{"bearer_token":{}}},
   *    summary="Delete subject by id",
   *    description="Deletes subject by id",
   * 
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="Subject id",
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
    $response = $this->SubjectManagerService->delete($request);

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