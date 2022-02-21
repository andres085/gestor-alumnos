<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\HomeworkController;
use App\Http\Controllers\Api\RotationController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\GroupStudentController;
use App\Http\Controllers\Api\RotationStudentController;
use App\Http\Controllers\Api\StudentAttendanceController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/students', StudentController::class);
Route::apiResource('/rotations', RotationController::class);
Route::apiResource('/rotations/{id}/students', RotationStudentController::class);
Route::apiResource('/attendances', AttendanceController::class);
Route::apiResource('/student-attendances', StudentAttendanceController::class);
Route::apiResource('/homework', HomeworkController::class);
Route::apiResource('/group-students', GroupStudentController::class);
