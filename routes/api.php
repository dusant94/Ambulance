<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PatientController;
use Illuminate\Http\Request;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/doctors/table', [DoctorController::class, 'table']);
    Route::get('/patients/table', [PatientController::class, 'table']);

    Route::group(['middleware' => 'admin'], function () {

        Route::group(['prefix' => '/doctors'], function () {
            Route::get('/types', [DoctorController::class, 'types']);
            Route::put('/{id}', [DoctorController::class, 'update']);
            Route::post('/', [DoctorController::class, 'store']);
            Route::delete('/{id}', [DoctorController::class, 'destroy']);
        });
        Route::group(['prefix' => '/patients'], function () {
            Route::put('/{id}', [PatientController::class, 'update']);
            Route::post('/', [PatientController::class, 'store']);
            Route::delete('/{id}', [PatientController::class, 'destroy']);
        });
    });

    Route::group(['prefix' => '/examinations'], function () {
        Route::get('/table', [ExaminationController::class, 'table']);
        Route::put('/{id}', [ExaminationController::class, 'update']);
        Route::post('/', [ExaminationController::class, 'store']);
        Route::delete('/{id}', [ExaminationController::class, 'destroy']);
    });
    Route::get('locations', [LocationController::class, 'index']);
});
