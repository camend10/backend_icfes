<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('login-simulador', [AuthController::class, 'loginSimulador']);
});

// Protected routes 
Route::middleware('jwt.verify')->group(function () {

    Route::prefix('users')->group(function () {
        Route::post('create', [UserController::class, 'create']);
        Route::post('/', [UserController::class, 'index']);
    });
});
