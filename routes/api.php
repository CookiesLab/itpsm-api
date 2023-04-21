<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\AcademicHistoryController;
use App\Http\Controllers\EquivalenceController;
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
use App\Http\Controllers\UserController;
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
//bloquear para student
  Route::apiResource('evaluations', EvaluationController::class);
  Route::apiResource('comments', CommentsController::class);
  Route::get('enrollments_student/{id}', [EnrollmentController::class, 'periods_student']);
  Route::apiResource('student-curricula', StudentCurriculaController::class);
  Route::get('student/student-curricula/{id}', [StudentCurriculaController::class,"showbystudentid"]);


  Route::get('logout', [AuthController::class, 'logout'])->name('logout');

  Route::get('logged-user', [AuthController::class, 'getLoggedUser'])->name('user');

  Route::get('initial-config', [InitialConfigController::class, 'getInitialConfig'])->name('initial.config');

  Route::put('users/reset-password', [AuthController::class, 'resetPassword'])->name('user.reset-password');

  Route::get('teacher/section', [TeacherController::class, 'getSections']);

  Route::group(['middleware' => ['role:admin']], function () {
    Route::get('allstudents', [StudentController::class, 'allStudents']);
    Route::get('teachers/all', [TeacherController::class, 'allTeachers']);
    Route::apiResource('students', StudentController::class);

    Route::apiResource('teachers', TeacherController::class);

    Route::apiResource('careers', CareerController::class);

    Route::apiResource('subjects', SubjectController::class);

    Route::apiResource('curricula', CurriculumController::class);

    Route::apiResource('academichistory', AcademicHistoryController::class);

    Route::apiResource('equivalence', EquivalenceController::class);



    Route::apiResource('prerequisites', PrerequisiteController::class);

    Route::get('curriculum-subjects/getcurriculabysubjectid', [CurriculumSubjectController::class, "getCurriculaBySubjectId"]);

    Route::get('curriculum-subjects/getsubjectsbystudentid/{id}',[CurriculumSubjectController::class, "getSubjectsByStudentId"]);



    Route::apiResource('curriculum-subjects', CurriculumSubjectController::class);

    Route::apiResource('scholarships', ScholarshipController::class);

    Route::apiResource('periods', PeriodController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('sections', SectionController::class);

    Route::post('students/create-default-pdf', [StudentController::class, 'createDefaultPdf'])->name('students.create-default-pdf');

    Route::post('students/generate-system-users', [StudentController::class, 'generateSystemUsers'])->name('students.generate-system-users');

    Route::post('teachers/generate-system-users', [TeacherController::class, 'generateSystemUsers'])->name('teachers.generate-system-users');

  });

  Route::group(['middleware' => ['role:teacher']], function () {
    //Route::apiResource('evaluations', EvaluationController::class);

    Route::apiResource('score-evaluations', ScoreEvaluationController::class);
    //Route::get('teacher/section', [TeacherController::class, 'getSections']);
    Route::put('evaluations/publish/{id}', [EvaluationController::class, 'publishEvaluations']);
    Route::put('evaluations/publishgrades/{id}', [EvaluationController::class, 'publishGrades']);
    Route::post('score/insertGrades', [ScoreEvaluationController::class, 'insertGrades']);
    Route::put('requestAprobacion/{id}', [EvaluationController::class, 'requestAprobacion']);
  });

  Route::group(['middleware' => ['role:student']], function () {
    Route::apiResource('enrollments', EnrollmentController::class);
    Route::get('section/getsubjects/{id}', [SectionController::class, 'getSectionsforStudent']);
    Route::get('evaluations/student/{id}', [EvaluationController::class, 'getEvaluationsforStudent']);
    Route::post('enrollment/enroll-subjects', [EnrollmentController::class, 'enrollSubjects'])->name('enrollment.enroll-subjects');
    Route::get('getequivalence/{id}', [EquivalenceController::class, 'getEquivalenceForStudents']);
    Route::get('getacademichistory/{id}', [AcademicHistoryController::class,'show']);

    Route::get('enrollment/active-subjects', [EnrollmentController::class, 'getSubjectsToBeEnrolled'])->name('enrollment.active-subjects');

    Route::get('enrollment/enrolled-curriculum-subjects', [EnrollmentController::class, 'getEnrolledCurriculumSubjects'])->name('enrollment.enrolled-curriculum-subjects');

    Route::get('enrollment/approved-subjects', [EnrollmentController::class, 'getApprovedCurriculumSubjects'])->name('enrollment.approved-subjects');
  });

});
