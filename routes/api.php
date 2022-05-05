<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\SubjectController;

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

Route::post('login', 'App\Http\Controllers\AuthController@login')->name('login');

Route::post('register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:api')->group(function() {

    Route::get('logout',  [AuthController::class, 'logout'])->name('logout');

    Route::get('logged-user',  [AuthController::class, 'getLoggedUser'])->name('user');

    Route::apiResource('students', StudentController::class);

    Route::apiResource('teachers', TeacherController::class);

    Route::apiResource('careers', CareerController::class);

    Route::apiResource('subjects', SubjectController::class);
});
