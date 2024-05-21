<?php

use App\Http\Controllers\Admin\V01\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth/admin')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
});
