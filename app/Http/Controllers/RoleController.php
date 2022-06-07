<?php

namespace App\Http\Controllers;

use App\Services\Roles\RoleManager;
use Illuminate\Http\Request;

class RoleController extends Controller
{
  protected RoleManager $RoleManagerService;

  /**
   * @param RoleManager $RoleManagerService
   */
  public function __construct(RoleManager $RoleManagerService)
  {
    $this->RoleManagerService = $RoleManagerService;
  }

  public function create(Request $request)
  {
    $receivedData = $request->data;
    $response = $this->RoleManagerService->create($receivedData['attributes']['name']);
    if (!$response['success']) {
      return response()->json([
        'errors' => [
          'type' => 'user',
          'status' => '500',
          'title' => $response['message'] ?? __('user.failure'),
          'detail' => $response['message'] ?? __('user.userFailure')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 500);
    }
    $Role = $response['role'];

    return response()->json([
      'data' => [
        'type' => 'role',
        'attributes' => $Role,
        'status' => '200',
        'message' => 'success',
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }


}
