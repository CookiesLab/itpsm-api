<?php
/**
 * @file
 * Module App Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\AuthenticationManager;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Repositories\User\UserInterface;
use Carbon\Carbon;

class AuthenticationManager {

    /**
	* User
	*
	* @var App\Repositories\User\UserInterface;
	*
	*/
    protected $User;

    /**
    * Carbon instance
    *
    * @var Carbon\Carbon
    *
    */
    protected $Carbon;

	public function __construct(
        UserInterface $User,
        Carbon $Carbon
    )
	{
        $this->User = $User;
		$this->Carbon = $Carbon;
    }

    public function login($credentials, $user, $remenberMe)
    {
        if(!Auth::attempt($credentials))
        {
            return [
                'status' => '401',
                'title' => __('auth.failure'),
                'detail' => __('auth.failAuthAttempt')
            ];
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if($remenberMe)
        {
            $token->expires_at = now()->addWeeks(1);
        }
        else
        {
            $token->expires_at = now()->addMinutes(120);
        }

        $token->save();

        return [
            'type' => 'auth',
            'id' => strval($user->id),
            'message' => __('auth.success'),
            'attributes' => $user,
            'token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $this->Carbon->parse($tokenResult->token->expires_at)->toDateTimeString()
        ];
    }

    public function register($data)
    {
        $user = $this->User->create($data);
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = now()->addMinutes(120);
        $token->save();

        return [
            'type' => 'user',
            'id' => strval($user->id),
            'message' => __('auth.success'),
            'attributes' => $user,
            'token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $this->Carbon->parse($tokenResult->token->expires_at)->toDateTimeString()
        ];
    }

    public function getLoggedUser($request, $json = true)
    {
        if($json)
        {
            return [
                'type' => 'user',
                'id' => strval($request->user()->id),
                'attributes' => $request->user(),
            ];
        }
        else {
            return $request->user();
        }
    }

    public function logout($request)
    {
        $request->user()->token()->revoke();

        return [
            'type' => 'auth',
            'message' => __('auth.logoutSuccess'),
        ];
    }
}
