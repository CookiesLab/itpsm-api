<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\CurriculumSubjectController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\InitialConfigController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\PrerequisiteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\ScoreEvaluationController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentCurriculaController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:api')->group(function () {

  Route::get('logout', [AuthController::class, 'logout'])->name('logout');

  Route::get('logged-user', [AuthController::class, 'getLoggedUser'])->name('user');

  Route::get('initial-config', [InitialConfigController::class, 'getInitialConfig'])->name('initial.config');

  Route::put('users/reset-password', [AuthController::class, 'resetPassword'])->name('user.reset-password');

  Route::group(['middleware' => ['role:admin']], function () {
    Route::apiResource('students', StudentController::class);

    Route::apiResource('teachers', TeacherController::class);

    Route::apiResource('careers', CareerController::class);

    Route::apiResource('subjects', SubjectController::class);

    Route::apiResource('curricula', CurriculumController::class);

    Route::apiResource('prerequisites', PrerequisiteController::class);

    Route::apiResource('curriculum-subjects', CurriculumSubjectController::class);

    Route::apiResource('scholarships', ScholarshipController::class);

    Route::apiResource('student-curricula', StudentCurriculaController::class);

    Route::apiResource('periods', PeriodController::class);

    Route::apiResource('sections', SectionController::class);

    Route::post('students/create-default-pdf', [StudentController::class, 'createDefaultPdf'])->name('students.create-default-pdf');

    Route::post('students/generate-system-users', [StudentController::class, 'generateSystemUsers'])->name('students.generate-system-users');

    Route::post('teachers/generate-system-users', [TeacherController::class, 'generateSystemUsers'])->name('teachers.generate-system-users');
  });

  Route::group(['middleware' => ['role:teacher']], function () {
    Route::apiResource('evaluations', EvaluationController::class);

    Route::apiResource('score-evaluations', ScoreEvaluationController::class);

  });

  Route::group(['middleware' => ['role:student']], function () {
    Route::apiResource('enrollments', EnrollmentController::class);

    Route::post('enrollment/enroll-subjects', [EnrollmentController::class, 'enrollSubjects'])->name('enrollment.enroll-subjects');

    Route::get('enrollment/active-subjects', [EnrollmentController::class, 'getSubjectsToBeEnrolled'])->name('enrollment.active-subjects');

    Route::get('enrollment/enrolled-curriculum-subjects', [EnrollmentController::class, 'getEnrolledCurriculumSubjects'])->name('enrollment.enrolled-curriculum-subjects');

    Route::get('enrollment/approved-subjects', [EnrollmentController::class, 'getApprovedCurriculumSubjects'])->name('enrollment.approved-subjects');
  });

});
