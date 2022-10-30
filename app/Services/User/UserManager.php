<?php

/**
 * @file
 * Teacher Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\User;

use App\Repositories\Teacher\TeacherInterface;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Pdf;
use Carbon\Carbon;

class UserManager
{


  /**
   * User
   *
   * @var App\Repositories\User\UserInterface;
   *
   */
  protected $User;

  /**
	* Barryvdh\DomPDF\PDF
	* @var Excel
	*/
	protected $Dompdf;

  /**
   * Carbon instance
   *
   * @var Carbon\Carbon
   *
   */
  protected $Carbon;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(

    UserInterface $User,
    PDF $Dompdf,
    Carbon $Carbon
  ) {

    $this->User = $User;
    $this->Dompdf = $Dompdf;
    $this->Carbon = $Carbon;
    $this->responseType = 'users';
  }

  public function getTableRowsWithPagination($request, $pager = true, $returnJson = true)
  {
    $rows = [];
    $limit = $offset = $count = $page = $totalPages = 0;
    $filter = $sortColumn = $sortOrder = '';

    if (!empty($request['filter']))
    {
      $filter = $request['filter'];
    }

    if (!empty($request['sort']) && $request['sort'][0] == '-')
    {
      $sortColumn = substr($request['sort'], 1);
      $sortOrder = 'desc';
    }
    else if (!empty($request['sort']))
    {
      $sortColumn = $request['sort'];
      $sortOrder = 'asc';
    }
    else
    {
      $sortColumn = 'id';
      $sortOrder = 'desc';
    }

    if ($pager)
    {
      $count = $this->User->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->User->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder)->each(function ($user) use (&$rows) {

      $id = strval($user->id);
      unset($user->id);

      array_push($rows, [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $user
      ]);
    });

    return [
      'rows' => $rows,
      'page' => $page,
      'totalPages' => $totalPages,
      'records' => $count,
    ];
  }

  public function getTeacher($id)
  {
    return $this->Teacher->byId($id);
  }

  public function generateSystemUsers() {

    $users = [];

    $this->Teacher->getWithoutUser()->each(function ($teacher) use (&$users) {
      $generatedPassword = strtoupper(Str::random(8));

      $data = [
        'name'=> $teacher->name . ' ' . $teacher->last_name,
        'email'=> $teacher->institutional_email,
        'password'=> bcrypt($generatedPassword),
        'system_reference_table'=> 'teachers',
        'system_reference_id'=> $teacher->id,
      ];

      $user = $this->User->create($data);
      $user->assignRole('teacher');
      $this->Teacher->update(['is_user_created' => 1], $teacher);

      $user->carnet = $teacher->carnet;
      $user->password = $generatedPassword;

      array_push($users, $user);
    });

    $data = [
      'users' => $users
    ];

    return $this->Dompdf
      ->loadView('system-users-data-pdf', $data)
      ->setPaper('letter')
      ->download('UsuariosCreados.pdf');
  }


  public function create($request)
  {
    $data = $request->all();

  

    $user = $this->User->create($data);
    $id = strval($user->id);
    unset($user->id);

    return [
      'success' => true,
      'user' => $user,
      'id' => $id,
    ];
  }

  public function update($request, $id)
  {
    $teacher = $this->Teacher->byId($id);

    if (empty($teacher)) {
      return [
        'success' => false,
      ];
    }

    $this->Teacher->update($request->all(), $teacher);
    $teacher = $this->Teacher->byId($id);
    unset($teacher->id);

    return [
      'success' => true,
      'teacher' => $teacher,
      'id' => $id,
    ];

  }

  public function delete($id)
  {
    $Teacher = $this->Teacher->byId($id);

    if (empty($Teacher)) {
      return false;
    }

    $this->Teacher->delete($id);

    return true;
  }

  private function generateCarnet($lastName, $entryYear, $birthDate) {
    $birthYear = $this->Carbon->createFromFormat('Y-m-d', $birthDate, config('app.timezone'))->year;
    $carnet = strtoupper(substr($lastName, 0, 2)) . ($birthYear % 100) . ($entryYear % 100) . str_pad($this->Teacher->getNextCarnet($entryYear), 3, '0', STR_PAD_LEFT);
    return $carnet;
  }
}
