<?php

use App\Http\Controllers\Mobile\V01\AuthController;
use App\Http\Controllers\Mobile\V01\CareerController;
use App\Http\Controllers\Mobile\V01\EventController;
use App\Http\Controllers\Mobile\V01\FinancialAidController;
use App\Http\Controllers\Mobile\V01\GetFilterListController;
use App\Http\Controllers\Mobile\V01\ScholarshipController;
use App\Http\Controllers\Mobile\V01\UniversityController;
use App\Http\Controllers\Mobile\V01\UniversityEventController;
use App\Http\Controllers\Mobile\V01\UniversityProgramController;
use App\Models\FinancialAid;
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
    Route::get('/tuition/{id}',[UniversityController::class, 'getTuition']);
    Route::get('program/degreeLevel/{id}', [UniversityProgramController::class, 'getProgramDegreeLevel']);
    Route::get('program/major/{id}', [UniversityProgramController::class, 'getProgramMajor']);
    Route::get('program/specialize/{id}',[UniversityProgramController::class, 'getProgramSpecialize']);
    Route::get('/program/major/detail/{id}',[UniversityProgramController::class, 'getMajorProgramDetail']); // major id
    Route::get('/program/specialize/detail/{id}',[UniversityProgramController::class, 'getSpecializeProgramDetail']);
    //specialize id
    Route::get('/scholarships/{id}',[ScholarshipController::class, 'index']);
    Route::get('/scholarship/detail/{id}',[ScholarshipController::class, 'show']); //scholarship id
    Route::get('/events/{id}',[UniversityEventController::class,'index']);
    Route::get('/event/detail/{id}',[UniversityEventController::class,'show']);
});

Route::prefix('getFilter')->group(function () {
   Route::get('majors',[GetFilterListController::class, 'getMajors']);
   Route::get('types',[GetFilterListController::class, 'getTypes']);
   Route::get('locations',[GetFilterListController::class,'getLocations']);
   Route::get('degrees',[GetFilterListController::class, 'getDegrees']);
});

Route::prefix('careers')->group(function () {
    Route::get('/types',[CareerController::class,'type']);
    Route::get('',[CareerController::class,'index']);
    Route::get('/{id}',[CareerController::class,'show']);

});

Route::prefix('events')->group(function () {
    Route::get('category',[EventController::class, 'category']);
    Route::get('',[EventController::class,'index']);
    Route::get('/{id}',[EventController::class,'show']);
});

Route::prefix('financial_aids')->group(function () {
    Route::get('',[FinancialAidController::class,'index']);
    Route::get('/{id}',[FinancialAidController::class,'show']);
    Route::get('/more_articles/{id}',[FinancialAidController::class,'moreArticle']);
});

Route::prefix('scholarships')->group(function () {
    Route::get('',[ScholarshipController::class,'getList']);
    Route::get('/{id}',[ScholarshipController::class,'show']);
});



