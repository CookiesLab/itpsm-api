<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScoreEvaluationRequest;
use Illuminate\Http\Request;
use App\Services\ScoreEvaluation\ScoreEvaluationManager;

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
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    ScoreEvaluationManager $ScoreEvaluationManagerService
  ) {
    $this->ScoreEvaluationManagerService = $ScoreEvaluationManagerService;
    $this->responseType = 'scoreEvaluations';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
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
}
