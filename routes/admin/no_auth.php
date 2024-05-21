<?php

use App\Http\Controllers\Admin\V01\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth/admin')->group(function () {
    Route::post('/login',[AuthController::class, 'login']);
    Route::get('/refresh_token',[AuthController::class, 'refresh_token'])->middleware(['auth:sanctum','type.refresh_token']);
});

