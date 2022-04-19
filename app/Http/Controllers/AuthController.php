<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\Authentication\AuthenticationManager;

class AuthController extends Controller
{
  /**
   * Authentication Manager Service
   *
   * @var App\Services\Authentication\AuthenticationManager;
   *
   */
  protected $AuthenticationManagerService;

  public function __construct(
    AuthenticationManager $AuthenticationManagerService
  ) {
    $this->AuthenticationManagerService = $AuthenticationManagerService;
  }

  public function login(LoginRequest $request)
  {
    $credentials = request(['email', 'password']);
    $response = $this->AuthenticationManagerService->login($credentials, $request);

    if (!$response['success']) {
      return response()->json([
        'errors' => [
          'type' => 'auth',
          'status' => '401',
          'title' => $response['message'] ?? __('auth.failure'),
          'detail' => $response['message'] ?? __('auth.failAuthAttempt')
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 401);
    }

    $user = $response['user'];

    return response()->json([
      'data' => [
        'type' => 'auth',
        'status' => '200',
        'id' => strval($user->id),
        'message' => __('auth.success'),
        'attributes' => $user,
        'token' => $response['token'],
        'token_type' => $response['token_type'],
        'expires_at' => $response['expires_at'],
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);

  }

  public function register(RegisterRequest $request)
  {
    $data = [
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($request->password),
    ];

    $response = $this->AuthenticationManagerService->register($data);

    if (!$response['success']) {
      return response()->json([
        'errors' => [
          'type' => 'auth',
          'status' => '401',
          'title' => $response['message'],
          'detail' => $response['message'],
        ],
        'jsonapi' => [
          'version' => "1.00"
        ]
      ], 401);
    }

    $user = $response['user'];

    return response()->json([
      'data' => [
        'type' => 'user',
        'id' => strval($user->id),
        'message' => __('auth.success'),
        'attributes' => $user,
        'token' => $response['token'],
        'token_type' => $response['token_type'],
        'expires_at' => $response['expires_at'],
      ],
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 201);
  }


  public function getLoggedUser(Request $request)
  {
    return $this->AuthenticationManagerService->getApiLoggedUser($request);
  }

  public function logout(Request $request)
  {
    return $this->AuthenticationManagerService->logout($request);
  }
}
