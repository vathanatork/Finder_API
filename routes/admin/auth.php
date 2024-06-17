<?php

use App\Http\Controllers\Admin\V01\AdmissionsController;
use App\Http\Controllers\Admin\V01\AdrController;
use App\Http\Controllers\Admin\V01\AuthController;
use App\Http\Controllers\Admin\V01\ContactInformationController;
use App\Http\Controllers\Admin\V01\DegreeLevelController;
use App\Http\Controllers\Admin\V01\DegreeLevelRelationController;
use App\Http\Controllers\Admin\V01\EditorHandlerController;
use App\Http\Controllers\Admin\V01\EventCategoryController;
use App\Http\Controllers\Admin\V01\MajorAndSpecializeNameController;
use App\Http\Controllers\Admin\V01\MajorController;
use App\Http\Controllers\Admin\V01\ScholarshipController;
use App\Http\Controllers\Admin\V01\UniversityController;
use App\Http\Controllers\Admin\V01\UniversityTypeController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth/admin')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::post('/editor/upload_image',[EditorHandlerController::class,'uploadImage']);

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
    Route::get('',[UniversityController::class, 'index']);
    Route::post('',[UniversityController::class,'create']);
    Route::get('/{id}',[UniversityController::class, 'show']);
    Route::put('/{id}',[UniversityController::class, 'update']);
    Route::delete('/{id}',[UniversityController::class, 'destroy']);
});

Route::prefix('majors')->group(function () {
    Route::get('',[MajorController::class,'index']);
    Route::get('/{id}',[MajorController::class,'show']);
    Route::post('',[MajorController::class,'create']);
    Route::put('/{id}',[MajorController::class,'update']);
    Route::delete('/{id}',[MajorController::class,'destroy']);
});

Route::prefix('major_and_specialize_names')->group(function () {
    Route::get('',[MajorAndSpecializeNameController::class,'index']);
    Route::post('',[MajorAndSpecializeNameController::class,'create']);
    Route::get('/{id}',[MajorAndSpecializeNameController::class,'show']);
    Route::put('/{id}',[MajorAndSpecializeNameController::class,'update']);
});

Route::prefix('degree_level_relation')->group(function () {
    Route::post('/major',[DegreeLevelRelationController::class,'createMajorDegree']);
    Route::post('/specialize',[DegreeLevelRelationController::class,'createSpecializeDegree']);
    Route::post('/university',[DegreeLevelRelationController::class,'createUniversityDegree']);
});

Route::prefix('admissions')->group(function () {
    Route::post('',[AdmissionsController::class,'create']);
    Route::get('',[AdmissionsController::class,'index']);
    Route::get('/{id}',[AdmissionsController::class,'show']);
    Route::put('/{id}',[AdmissionsController::class,'update']);
    Route::delete('/{id}',[AdmissionsController::class, 'destroy']);
});

Route::prefix('scholarShips')->group(function () {
    Route::post('',[ScholarshipController::class,'create']);
    Route::get('',[ScholarshipController::class,'index']);
    Route::get('/{id}',[ScholarshipController::class,'show']);
    Route::put('/{id}',[ScholarshipController::class,'update']);
    Route::delete('/{id}',[ScholarshipController::class, 'destroy']);
});

Route::prefix('event_categories')->group(function () {
    Route::post('',[EventCategoryController::class,'create']);
    Route::get('',[EventCategoryController::class,'index']);
    Route::get('/{id}',[EventCategoryController::class,'show']);
    Route::put('/{id}',[EventCategoryController::class,'update']);
});

//Route::prefix('events')->group(function () {
//    Route::post('',[EventCategoryController::class,'create']);
//    Route::get('',[EventCategoryController::class,'index']);
//    Route::get('/{id}',[EventCategoryController::class,'show']);
//    Route::put('/{id}',[EventCategoryController::class,'update']);
//});

