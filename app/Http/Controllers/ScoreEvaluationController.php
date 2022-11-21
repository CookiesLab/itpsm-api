<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScoreEvaluationRequest;
use Illuminate\Http\Request;
use App\Services\ScoreEvaluation\ScoreEvaluationManager;
use App\Services\Evaluation\EvaluationManager;
class ScoreEvaluationController extends Controller
{
  /**
   * ScoreEvaluation Manager Service
   *
   * @var App\Services\ScoreEvaluationManager\ScoreEvaluationManagementInterface;
   *
   */
  protected $ScoreEvaluationManagerService;
   /**
   * ScoreEvaluation Manager Service
   *
   * @var App\Services\ScoreEvaluationManager\EvaluationManagementInterface;
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
      ScoreEvaluationManager $ScoreEvaluationManagerService,
      EvaluationManager $EvaluationManagerService
  ) {
    $this->ScoreEvaluationManagerService = $ScoreEvaluationManagerService;
    $this->EvaluationManagerService = $EvaluationManagerService;
    $this->responseType = 'scoreEvaluations';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
       /**
   *  @OA\Get(
   *    path="/api/score-evaluations",
   *    operationId="getScore-evaluations",
   *    tags={"Assign evaluation score"},
   * security={{"bearer_token":{}}},
   *    summary="Get evaluation score list",
   *    description="Returns evaluation score list and allows to filter by student id or evaluation id ",
   *
   *  @OA\Parameter(
   *      name="query",
   *      in="query",
   *      description="filter format like:{""query"":[{""field"":""se.student_id"",""op"":""="",""data"":""2""}]}",
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
    $response = $this->ScoreEvaluationManagerService->getTableRowsWithPagination(request()->all());

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
   *    path="/api/score-evaluations",
   *    operationId="postScore-evaluations",
   *    tags={"Assign evaluation score"},
   * security={{"bearer_token":{}}},
   *    summary="Assign evaluation score",
   *    description="Assign evaluation score",
   *
   *    @OA\Parameter(
   *      name="score",
   *      in="query",
   *      description="Evaluation score",
   *      required=true,
   *      @OA\Schema(
   *        type="number",
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="student_id",
   *      in="query",
   *      description="Student to assign score",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="evaluation_id",
   *      in="query",
   *      description="Evaluation to assign score",
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
  public function store(ScoreEvaluationRequest $request)
  {
    $response = $this->ScoreEvaluationManagerService->create($request);

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $response['id'],
        'attributes' => $response['scoreEvaluation']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\ScoreEvaluation  $ScoreEvaluation
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $scoreEvaluation = $this->ScoreEvaluationManagerService->getScoreEvaluation($id);

    if (empty($scoreEvaluation)) {
      return response()->json([
        'errors' => [
          'status' => '401',
          'title' => __('base.failure'),
          'detail' => __('base.ScoreEvaluationNotFound')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 404);
    }

    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'attributes' => $scoreEvaluation
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
   * @param  \App\Models\ScoreEvaluation  $ScoreEvaluation
   * @return \Illuminate\Http\Response
   */
  /**
   *  @OA\Put(
   *    path="/api/score-evaluations/{id}",
   *    operationId="putScore-evaluations",
   *    tags={"Assign evaluation score"},
   * security={{"bearer_token":{}}},
   *    summary="Update evaluation score",
   *    description="Update evaluation score",
   *
   *   @OA\Parameter(
   *      name="id",
   *      in="path",
   *      required=true,
   *      description="Score evaluation id",
   *      @OA\Schema(
   *        type="integer"
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="score",
   *      in="query",
   *      description="Evaluation score",
   *      required=true,
   *      @OA\Schema(
   *        type="number",
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="student_id",
   *      in="query",
   *      description="Student to assign score",
   *      required=true,
   *      @OA\Schema(
   *        type="integer",
   *      )
   *    ),
   *
   *    @OA\Parameter(
   *      name="evaluation_id",
   *      in="query",
   *      description="Evaluation to assign score",
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
  public function update(ScoreEvaluationRequest $request, $data)
  {
    $response = $this->ScoreEvaluationManagerService->update($request, $data);

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
        'attributes' => $response['scoreEvaluation']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\ScoreEvaluation  $ScoreEvaluation
   * @return \Illuminate\Http\Response
   */
        /**
   *  @OA\Delete(
   *    path="/api/score-evaluations/{id}",
   *    operationId="Delete score-evaluations by id",
   *    tags={"Assign evaluation score"},
   * security={{"bearer_token":{}}},
   *    summary="Delete score-evaluations by id",
   *    description="Delete score-evaluations by id",
   *
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="score-evaluations id",
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
    $response = $this->ScoreEvaluationManagerService->delete($request);

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
  public function insertGrades(Request $request)
  {
    $eval=0;
    $enrolled = $notEnrolled = [];
    foreach ($request->grades as $grade) {

      $eval=$grade['evaluation_id'];
      if($grade['oldscore']==null ){
        $response = $this->ScoreEvaluationManagerService->create($grade);
      }else{
        $response = $this->ScoreEvaluationManagerService->update($request, $grade);
      }


      if ($response['success']) {
        array_push($enrolled, $response['scoreEvaluation']);
      }
      else {
        array_push($notEnrolled, $grade);
      }
  }
  $response2 = $this->EvaluationManagerService->uploadgrades($eval);
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
}
