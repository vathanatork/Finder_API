<?php

use App\Http\Controllers\Mobile\V01\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth/user')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
});

