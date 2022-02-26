<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Services\AuthenticationManager\AuthenticationManager;

class AuthController extends Controller
{
    /**
	 * Authentication Manager Service
	 *
	 * @var App\Services\AuthenticationManager\AuthenticationManager;
	 *
	 */
	protected $AuthenticationManagerService;

    public function __construct(
		AuthenticationManager $AuthenticationManagerService
	)
	{
		$this->AuthenticationManagerService = $AuthenticationManagerService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        $response = $this->AuthenticationManagerService->login($credentials);

        if (!$response->success)
        {
            return response()->json([
                'errors' => [
                    'status' => '401',
                    'title' => __('auth.failure'),
                    'detail' => __('auth.failAuthAttempt')
                ],
                'jsonapi' => [
                    'version' => "1.00"
                ]
            ], 401);
        }

        return response()->json([
            'data' => [
                'type' => 'auth',
                'id' => strval($user->id),
                'message' => __('auth.success'),
                'attributes' => $response->user,
                'token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => $this->Carbon->parse($tokenResult->token->expires_at)->toDateTimeString()
            ],
            'jsonapi' => [
                'version' => "1.00"
            ]
        ], 200);
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
