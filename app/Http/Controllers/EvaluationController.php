<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvaluationRequest;
use Illuminate\Http\Request;
use App\Services\Evaluation\CommentsManager;

class EvaluationController extends Controller
{
  /**
   * Evaluation Manager Service
   *
   * @var App\Services\EvaluationManager\EvaluationManagementInterface;
   *
   */
  protected $EvaluationManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
      CommentsManager $EvaluationManagerService
  ) {
    $this->EvaluationManagerService = $EvaluationManagerService;
    $this->responseType = 'evaluations';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
     /**
   *  @OA\Get(
   *    path="/api/evaluations",
   *    operationId="getEvaluation",
   *    tags={"Evaluations"},
   * security={{"bearer_token":{}}},
   *    summary="Get evaluation list",
   *    description="Returns evaluation list",
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
    $response = $this->EvaluationManagerService->getTableRowsWithPagination(request()->all());

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
   *    path="/api/evaluations",
   *    operationId="postEvaluation",
   *    tags={"Evaluations"},
   * security={{"bearer_token":{}}},
   *    summary="Create evaluation",
   *    description="Create evaluation",
   *
   *    @OA\Parameter(
   *      name="name",
   *      in="query",
   *      description="Evaluation name to create",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="description",
   *      in="query",
   *      description="Evaluation description",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="date",
   *      in="query",
   *      description="Evaluation date",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *        format="date"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="percentage",
   *      in="query",
   *      description="Evaluation percentage",
   *      required=true,
   *      @OA\Schema(
   *        type="number",
   *      )
   *    ),
   *
   *   @OA\Parameter(
   *      name="section_id",
   *      in="query",
   *      description="Evaluation section_id",
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
  public function store(EvaluationRequest $request)
  {
    $response = $this->EvaluationManagerService->create($request);
    if(!$response['success']){
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.EvaluationNotCreated')
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
        'attributes' => $response['evaluation']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Evaluation  $Evaluation
   * @return \Illuminate\Http\Response
   */
    /**
   *  @OA\Get(
   *    path="/api/evaluations/{id}",
   *    operationId="get evaluation by id",
   *    tags={"Evaluations"},
   * security={{"bearer_token":{}}},
   *    summary="Get evaluation by id",
   *    description="Returns evaluation by id",
   *
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="Evaluation id",
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
    $evaluation = $this->EvaluationManagerService->getEvaluation($id);

    if (empty($evaluation)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.EvaluationNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    $id = strval($evaluation->id);
    unset($evaluation->id);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $evaluation
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
   * @param  \App\Models\Evaluation  $Evaluation
   * @return \Illuminate\Http\Response
   */
      /**
   *  @OA\Put(
   *    path="/api/evaluations/{id}",
   *    operationId="putEvaluation",
   *    tags={"Evaluations"},
   * security={{"bearer_token":{}}},
   *    summary="Update evaluation",
   *    description="Update evaluation",
   *
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      required=true,
   *      description="Evaluation id",
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
   *      name="description",
   *      in="query",
   *      description="Evaluation description",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="date",
   *      in="query",
   *      description="Evaluation date",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *        format="date"
   *      )
   *    ),
   *
   *     @OA\Parameter(
   *      name="percentage",
   *      in="query",
   *      description="Evaluation percentage",
   *      required=true,
   *      @OA\Schema(
   *        type="number",
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="section_id",
   *      in="query",
   *      description="Evaluation section_id",
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
  public function update(EvaluationRequest $request, $data)
  {
    $response = $this->EvaluationManagerService->update($request, $data);

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
        'attributes' => $response['evaluation']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Evaluation  $Evaluation
   * @return \Illuminate\Http\Response
   */
    /**
   *  @OA\Delete(
   *    path="/api/evaluations/{id}",
   *    operationId="delete evaluation by id",
   *    tags={"Evaluations"},
   * security={{"bearer_token":{}}},
   *    summary="Delete evaluation by id",
   *    description="Deletes evaluation by id",
   *
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="Evaluation id",
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
    $response = $this->EvaluationManagerService->delete($request);

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
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \App\Models\Evaluation  $Evaluation
   * @return \Illuminate\Http\Response
   */
      /**
   *  @OA\Put(
   *    path="api/evaluations/publish/{id}",
   *    operationId="publishEvaluation",
   *    tags={"Evaluations"},
   * security={{"bearer_token":{}}},

   *    summary="publish Evaluation to Students",
   *    description="publish Evaluation  to Students",
   * 

   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      required=true,
   *      description="Evaluation id",
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
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
   *      name="description",
   *      in="query",
   *      description="Evaluation description",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="date",
   *      in="query",
   *      description="Evaluation date",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *        format="date"
   *      )
   *    ),
   *
   *     @OA\Parameter(
   *      name="percentage",
   *      in="query",
   *      description="Evaluation percentage",
   *      required=true,
   *      @OA\Schema(
   *        type="number",
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="section_id",
   *      in="query",
   *      description="Evaluation section_id",
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
  public function publishEvaluations($id)
  {
    $response = $this->EvaluationManagerService->publish($id);

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
        'type' => $this->responseType
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
   * @param  \App\Models\Evaluation  $Evaluation
   * @return \Illuminate\Http\Response
   */
      /**
   *  @OA\Put(
   *    path="api/evaluations/publishgrades/{id}",
   *    operationId="putEvaluationGrades",
   *    tags={"Evaluations"},
   * security={{"bearer_token":{}}},

   *    summary="publish evaluation grades",
   *    description="publish evaluation grades",

   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      required=true,
   *      description="Evaluation id",
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
   *      name="description",
   *      in="query",
   *      description="Evaluation description",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="date",
   *      in="query",
   *      description="Evaluation date",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *        format="date"
   *      )
   *    ),
   *
   *     @OA\Parameter(
   *      name="percentage",
   *      in="query",
   *      description="Evaluation percentage",
   *      required=true,
   *      @OA\Schema(
   *        type="number",
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="section_id",
   *      in="query",
   *      description="Evaluation section_id",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
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
  public function publishGrades($id)
  {
    $response = $this->EvaluationManagerService->publishgrades($id);

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
        'type' => $this->responseType
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }
    /**
   * Display the specified resource.
   *
   * @param  \App\Models\Evaluation  $Evaluation
   * @return \Illuminate\Http\Response
   */
    /**
   *  @OA\Get(
   *    path="api/evaluations/student/{id}",
   *    operationId="get evaluations by student and period id",
   *    tags={"Evaluations"},
   * security={{"bearer_token":{}}},

   *    summary="Get evaluation by  student id",
   *    description="Returns evaluations for the student",
   * 

   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="Student id",
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
  public function getEvaluationsforStudent($id)
  {
    $evaluation = $this->EvaluationManagerService->getEvaluations($id);

    if (!$evaluation['success']) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.EvaluationNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }



    return response()->json([
      'data' => [
        'type' => $this->responseType,

        'attributes' => $evaluation['evaluation']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }
}
