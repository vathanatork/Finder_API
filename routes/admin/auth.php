<?php

use App\Http\Controllers\Admin\V01\AdrController;
use App\Http\Controllers\Admin\V01\AuthController;
use App\Http\Controllers\Admin\V01\ContactInformationController;
use App\Http\Controllers\Admin\V01\DegreeLevelController;
use App\Http\Controllers\Admin\V01\UniversityController;
use App\Http\Controllers\Admin\V01\UniversityTypeController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth/admin')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::prefix('university_types')->group(function () {
    Route::post('',[UniversityTypeController::class,'create']);
    Route::get('',[UniversityTypeController::class, 'index']);
    Route::get('/{id}',[UniversityTypeController::class, 'show']);
    Route::put('/{id}',[UniversityTypeController::class, 'update']);
    Route::delete('/{id}',[UniversityTypeController::class, 'destroy']);
});

Route::prefix('contact_information')->group(function () {
    Route::post('',[ContactInformationController::class,'create']);
    Route::get('',[ContactInformationController::class,'index']);
    Route::get('/{id}',[ContactInformationController::class,'show']);
    Route::put('/{id}',[ContactInformationController::class,'update']);
    Route::delete('/{id}',[ContactInformationController::class,'destroy']);
});

Route::prefix('adr')->group(function () {
    Route::get('/province',[AdrController::class,'province']);
    Route::get('/district/{id}',[AdrController::class, 'district']);
    Route::get('/commune/{id}',[AdrController::class, 'commune']);
    Route::get('/village/{id}',[AdrController::class, 'village']);
});

Route::prefix('degree_levels')->group(function () {
    Route::get('',[DegreeLevelController::class,'index']);
    Route::post('',[DegreeLevelController::class,'create']);
    Route::get('/{id}',[DegreeLevelController::class,'show']);
    Route::put('/{id}',[DegreeLevelController::class,'update']);
    Route::delete('/{id}',[DegreeLevelController::class,'destroy']);
});

Route::prefix('universities')->group(function () {
    Route::post('',[UniversityController::class,'create']);
});
