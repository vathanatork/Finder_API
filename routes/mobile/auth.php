<?php

use App\Http\Controllers\Mobile\V01\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('auth/user/logout', [AuthController::class, 'logout']);
