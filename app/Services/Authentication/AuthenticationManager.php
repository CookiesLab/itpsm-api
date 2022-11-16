<?php

/**
 * @file
 * Module App Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\Authentication;

use App\Repositories\User\UserInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;





class AuthenticationManager
{

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
    Carbon        $Carbon
  )
  {
    $this->User = $User;
    $this->Carbon = $Carbon;
  }

  public function login($credentials, $request)
  {
    if (!Auth::guard('web')->attempt($credentials)) {
      return [
        'success' => false,
      ];
    }

    try {
      $user = $this->User->byEmail($request->email);
      $tokenResult = $user->createToken('Personal Access Token');
      $token = $tokenResult->token;
      $token->expires_at = now('-6:00')->addHours(6);

      if ($user->hasRole('admin')) {
        $platformMenus = $this->getAdminPlatformMenus();
      }
      else if ($user->hasRole('teacher')) {
        $platformMenus = $this->getTeacherPlatformMenus();
      }
      else if ($user->hasRole('student')) {
        $platformMenus = $this->getStudentPlatformMenus();
      }
      else {
        $platformMenus = [];
      }

      $token->save();

      return [
        'success' => true,
        'user' => $user,
        'platform_menus' => $platformMenus,
        'token' => $tokenResult->accessToken,
        'token2' => $token->id,
        'token_type' => 'Bearer',
        'expires_at' => $this->Carbon->parse($tokenResult->token->expires_at)->toDateTimeString()
      ];
    } catch (\Throwable $th) {
      dd($th);
      return [
        'success' => false,
        'message' => __('common.internal_error')
      ];
    }
  }

  public function register($data)
  {
    try {
      $user = $this->User->create($data);
      $Role = Role::findById($data['role_id']);

      $user->assignRole($Role->name);

      $tokenResult = $user->createToken('Personal Access Token');
      $token = $tokenResult->token;
      $token->expires_at = now('-6:00')->addHours(6);
      $token->save();

      return [
        'success' => true,
        'user' => $user,
        'token' => $tokenResult->accessToken,
        'token_type' => 'Bearer',
        'expires_at' => $this->Carbon->parse($tokenResult->token->expires_at)->toDateTimeString()
      ];
    } catch (\Throwable $th) {
      return [
        'success' => false,
        'message' => __('common.internal_error')
      ];
    }

  }

  public function getLoggedUser($request, $json = true)
  {
    if ($json) {
      return [
        'type' => 'user',
        'id' => strval($request->user()->id),
        'attributes' => $request->user(),
      ];
    } else {
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

  public function resetPassword($data)
  {
    try {
      $updatedPassword = [
        'password' => $data['password']
      ];

      $response = $this->User->resetPassword($updatedPassword, $data['system_reference_table'], $data['system_reference_id']);

      return $response;
    } catch (\Throwable $th) {
      return false;
    }
  }

  private function getAdminPlatformMenus(){
    return [
      [
        "id" => 1,
        "name" => 'Usuarios',
        "redirectTo" => '/dashboard/usuarios',
        "icon" => "MdSchool",
      ],
      [
        "id" => 2,
        "name" => 'Estudiantes',
        "redirectTo" => '/dashboard/estudiantes',
        "icon" => "MdSchool",
      ],
      [
        "id" => 3,
        "name" => 'Catedráticos',
        "redirectTo" => '/dashboard/catedraticos',
        "icon" => "GiTeacher",
      ],
      [
        "id" => 4,
        "name" => 'Plan de estudios',
        "redirectTo" => '/dashboard/plan-de-estudio',
        "icon" => "AiTwotoneSchedule",
      ],
      [
        "id" => 5,
        "name" => 'Ciclo de estudios',
        "redirectTo" => '/dashboard/ciclo-de-estudios',
        "icon" => "AiOutlineCalendar",
      ]
      ,
      [
        "id" => 12,
        "name" => 'Aprobar Evaluaciones',
        "redirectTo" => '/dashboard/aprovaciones',
        "icon" => "AiOutlineCalendar",
      ],
    ];
  }

  private function getTeacherPlatformMenus(){
    return [
      [
        "id" => 7,
        "name" => 'Mis secciones',
        "redirectTo" => '/dashboard/mis-secciones',
        "icon" => "MdSchool",
      ],
      [
        "id" => 6,
        "name" => 'Evaluaciones',
        "redirectTo" => '/dashboard/evaluaciones',
        "icon" => "MdSchool",
      ],
    ];
  }

  private function getStudentPlatformMenus(){
    return [
      [
        "id" => 8,
        "name" => 'Información personal',
        "redirectTo" => '/dashboard/informacion-personal',
        "icon" => "MdSchool",
      ],
      [
        "id" => 9,
        "name" => 'Inscripción de materias',
        "redirectTo" => '/dashboard/inscripcion-de-materias',
        "icon" => "MdSchool",
      ],
      [
        "id" => 10,
        "name" => 'Historial academico',
        "redirectTo" => '/dashboard/historial-academico',
        "icon" => "MdSchool",
      ],
      [
        "id" => 11,
        "name" => 'Ver notas',
        "redirectTo" => '/dashboard/notas',
        "icon" => "MdSchool",
      ],
    ];
  }
}
