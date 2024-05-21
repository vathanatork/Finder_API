<?php

use App\Http\Controllers\Mobile\V01\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('user/register', [AuthController::class, 'register']);
    Route::post('user/refresh_token',[AuthController::class, 'refresh_token'])->middleware(['auth:sanctum','type.refresh_token']);
});

