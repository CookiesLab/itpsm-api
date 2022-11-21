<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentsRequest;
use Illuminate\Http\Request;
use App\Services\Comments\CommentsManager;
use Illuminate\Support\Facades\Log;
use App\Services\Evaluation\EvaluationManager;
class CommentsController extends Controller
{
  /**
   * Evaluation Manager Service
   *
   * @var App\Services\EvaluationManager\EvaluationManagementInterface;
   *
   */
  protected $EvaluationManagerService;

  /**
   * Evaluation Manager Service
   *
   * @var App\Services\EvaluationManager\EvaluationManagementInterface;
   *
   */
  protected $CommentsManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    EvaluationManager $EvaluationManagerService,
      CommentsManager $CommentsManagerService
  ) {
    $this->EvaluationManagerService = $EvaluationManagerService;
    $this->CommentsManagerService = $CommentsManagerService;
    $this->responseType = 'comments';
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
     /**
   *  @OA\Post(
   *    path="/api/comments",
   *    operationId="postComments",
   *    tags={"Comments"},
   * security={{"bearer_token":{}}},
   *    summary="Create comment",
   *    description="Create comment",
   *
   *    @OA\Parameter(
   *      name="comment",
   *      in="query",
   *      description="Evaluation name to create",
   *      required=true,
   *      @OA\Schema(
   *        type="string",
   *      )
   *    ),
   *   *   @OA\Parameter(
      *      name="id",
      *      in="query",
      *      description="Evaluation name to create",
      *      required=true,
      *      @OA\Schema(
      *        type="integer",
      *      )
      *    ),
      *

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
  public function store(CommentsRequest $request)
  {
    Log::emergency($request);
    $response = $this->CommentsManagerService->getcomment($request->id);
    Log::emergency($response);
    Log::emergency(empty($response));
    if(empty($response)){
      $response = $this->CommentsManagerService->create($request);
    }else{
      $response = $this->CommentsManagerService->update($request,$request->id);
    }

    $response2 = $this->EvaluationManagerService->aprobacion($request->id,$request->status);
    return response()->json([
      'data' => [
        'type' => $this->responseType,
        'id' => $response['id'],
      //  'attributes' => $response['evaluation']
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Comments  $Evaluation
   * @return \Illuminate\Http\Response
   */
    /**
   *  @OA\Get(
   *    path="/api/comments/{id}",
   *    operationId="get comments by id",
   *    tags={"Comments"},
   * security={{"bearer_token":{}}},
   *    summary="Get comments by id",
   *    description="Returns comments by id",
   *
   *    @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="Section id",
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
    $evaluation = $this->CommentsManagerService->getcomment($id);

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

}
