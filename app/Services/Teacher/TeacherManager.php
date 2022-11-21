<?php

/**
 * @file
 * Teacher Management Interface Implementation.
 *
 * All ModuleName code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Services\Teacher;

use App\Repositories\Teacher\TeacherInterface;
use App\Repositories\User\UserInterface;
use App\Repositories\Section\SectionInterface;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Pdf;
use Carbon\Carbon;

class TeacherManager
{
  /**
   * Teacher
   *
   * @var App\Repositories\Teacher\TeacherInterface;
   *
   */
  protected $Teacher;

  /**
   * User
   *
   * @var App\Repositories\User\UserInterface;
   *
   */
  protected $User;
    /**
   * Section
   *
   * @var App\Repositories\Section\SectionInterface;
   *
   */
  protected $Section;

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
    TeacherInterface $Teacher,
    UserInterface $User,
    SectionInterface $Section,
    PDF $Dompdf,
    Carbon $Carbon
  ) {
    $this->Teacher = $Teacher;
    $this->User = $User;
    $this->Section = $Section;
    $this->Dompdf = $Dompdf;
    $this->Carbon = $Carbon;
    $this->responseType = 'teachers';
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
      $count = $this->Teacher->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->Teacher->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder)->each(function ($teacher) use (&$rows) {

      $teacher->birth_date_with_format = !empty($teacher->birth_date)? $this->Carbon->createFromFormat('Y-m-d', $teacher->birth_date, config('app.timezone'))->format('d/m/Y') : null;
      $id = strval($teacher->id);
      unset($teacher->id);

      array_push($rows, [
        'type' => $this->responseType,
        'id' => $id,
        'attributes' => $teacher
      ]);
    });

    return [
      'rows' => $rows,
      'page' => $page,
      'totalPages' => $totalPages,
      'records' => $count,
    ];
  }
  
  public function getTableRowsWithPaginationSection($request, $pager = true, $returnJson = true)
  {

    $rows = [];
    $limit = $offset = $count = $page = $totalPages = 0;
    $filter = $sortColumn = $sortOrder = '';
    if (!empty($request['query']))
    {
      $customQuery = json_decode($request['query'], true)['query'];
    }

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
      $sortColumn = 's.code';
      $sortOrder = 'desc';
    }

    if ($pager)
    {
      $count = $this->Section->searchTableRowsWithPagination(true, $limit, $offset, $filter, $sortColumn, $sortOrder, $customQuery);
      encode_requested_data($request, $count, $limit, $offset, $totalPages, $page);
    }

    $this->Section->searchTableRowsWithPagination(false, $limit, $offset, $filter, $sortColumn, $sortOrder, $customQuery)->each(function ($teacher) use (&$rows) {

      array_push($rows, [
        'type' => $this->responseType,
        'id' => $teacher->code,
        'attributes' => $teacher
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
 
  public function getTeachers()
  {
    return $this->Teacher->all();
  }
 

  public function generateSystemUsers() {

    $users = [];

    $this->Teacher->getWithoutUser()->each(function ($teacher) use (&$users) {
      $generatedPassword = strtoupper(Str::random(8));

      $data = [
        'name'=> $teacher->name . ' ' . $teacher->last_name,
        'email'=> $teacher->institutional_email,
        'password'=> $generatedPassword,
        'system_reference_table'=> 'teachers',
        'system_reference_id'=> $teacher->id,
      ];

      $user = $this->User->create($data);
      $user->assignRole('teacher');
      $this->Teacher->update(['is_user_created' => 1], $teacher);

      $user->carnet = $teacher->carnet;
      $user->publicpassword = $generatedPassword;
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

    $carnet = $this->generateCarnet($data['last_name'], $data['entry_date'], $data['birth_date']);
    $data['carnet'] = $carnet;
    $data['institutional_email'] = $carnet . "@" . config('app.institutional_email_domain');

    $teacher = $this->Teacher->create($data);
    $id = strval($teacher->id);
    unset($teacher->id);

    return [
      'success' => true,
      'teacher' => $teacher,
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
