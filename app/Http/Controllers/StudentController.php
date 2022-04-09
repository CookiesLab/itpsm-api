<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StudentRequest;
use Illuminate\Http\Request;
use App\Services\Student\StudentManager;

class StudentController extends Controller
{
  // /**
  //  * Student Manager Service
  //  *
  //  * @var App\Services\StudentManager\StudentManagementInterface;
  //  *
  //  */
  // protected $StudentManagerService;

  // public function __construct(
  //   StudentManager $StudentManagerService
  // ) {
  //   $this->StudentManagerService = $StudentManagerService;
  // }


  // /**
  //  * Display a listing of the resource.
  //  *
  //  * @return \Illuminate\Http\Response
  //  */
  // public function index()
  // {
  //   return $this->StudentManagerService->getTableRowsWithPagination(request()->all());
  // }

  // /**
  //  * Store a newly created resource in storage.
  //  *
  //  * @param  \Illuminate\Http\Request  $request
  //  * @return \Illuminate\Http\Response
  //  */
  // public function store(StudentRequest $request)
  // {
  //   return $this->StudentManagerService->create($request);
  // }

  // /**
  //  * Display the specified resource.
  //  *
  //  * @param  \App\Models\Student  $Student
  //  * @return \Illuminate\Http\Response
  //  */
  // public function show($id)
  // {
  //   return $this->StudentManagerService->getStudent($id);
  // }

  // /**
  //  * Update the specified resource in storage.
  //  *
  //  * @param  \Illuminate\Http\Request  $request
  //  * @param  \App\Models\Student  $Student
  //  * @return \Illuminate\Http\Response
  //  */
  // public function update(StudentRequest $request, $data)
  // {
  //   return $this->StudentManagerService->update($request, $data);
  // }

  // /**
  //  * Remove the specified resource from storage.
  //  *
  //  * @param  \App\Models\Student  $Student
  //  * @return \Illuminate\Http\Response
  //  */
  // public function destroy($request)
  // {
  //   return $this->StudentManagerService->delete($request);
  // }
}
