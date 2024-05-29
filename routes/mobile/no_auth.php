<?php

use App\Http\Controllers\Mobile\V01\AuthController;
use App\Http\Controllers\Mobile\V01\UniversityController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth/user')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',[AuthController::class, 'login']);
    Route::get('/refresh_token',[AuthController::class, 'refresh_token'])->middleware(['auth:sanctum','type.refresh_token']);
});

Route::prefix('universities')->group(function () {
    Route::get('', [UniversityController::class, 'index']);
});
