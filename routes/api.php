<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\General\GeneralController;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('login-simulador', [AuthController::class, 'loginSimulador']);
});

// Protected routes
Route::middleware('jwt.verify')->group(function () {

    Route::prefix('users')->group(function () {
        Route::post('create', [UserController::class, 'create']);
        Route::put('update/{id}', [UserController::class, 'update']);
        Route::put('modify/{id}', [UserController::class, 'modifyUser']);
        Route::post('/', [UserController::class, 'index']);
        Route::post('upload', [UserController::class, 'upload']);
        Route::post('estado', [UserController::class, 'estado']);
        Route::post('by-id', [UserController::class, 'byid']);
    });

    Route::prefix('roles')->group(function () {
        Route::post('/', [RoleController::class, 'index']);
    });

    Route::prefix('generales')->group(function () {
        Route::post('/departamentos', [GeneralController::class, 'departamentos']);
        Route::post('/municipios', [GeneralController::class, 'municipios']);
        Route::post('/tipo-documentos', [GeneralController::class, 'tipodocs']);
    });
});
