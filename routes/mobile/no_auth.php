<?php

use App\Http\Controllers\Mobile\V01\AuthController;
use App\Http\Controllers\Mobile\V01\GetFilterListController;
use App\Http\Controllers\Mobile\V01\UniversityController;
use App\Http\Controllers\Mobile\V01\UniversityProgramController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth/user')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',[AuthController::class, 'login']);
    Route::get('/refresh_token',[AuthController::class, 'refresh_token'])->middleware(['auth:sanctum','type.refresh_token']);
});

Route::prefix('universities')->group(function () {
    Route::get('', [UniversityController::class, 'index']);
    Route::get('/overview/{id}', [UniversityController::class, 'getOverview']);
    Route::get('/admission/{id}', [UniversityController::class, 'getAdmission']);
    Route::get('/program/{id}', [UniversityProgramController::class, 'getProgram']);
    Route::get('/program/major/detail/{id}',[UniversityProgramController::class, 'getMajorProgramDetail']);
    Route::get('/program/specialize/detail/{id}',[UniversityProgramController::class, 'getSpecializeProgramDetail']);
//    Route::get('/major/{id}', [UniversityController::class, 'getMajor']);
});

Route::prefix('getFilter')->group(function () {
   Route::get('majors',[GetFilterListController::class, 'getMajors']);
   Route::get('types',[GetFilterListController::class, 'getTypes']);
   Route::get('locations',[GetFilterListController::class,'getLocations']);
   Route::get('degrees',[GetFilterListController::class, 'getDegrees']);
});
