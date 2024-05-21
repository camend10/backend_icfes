<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\General\GeneralController;
use App\Http\Controllers\Institucion\InstitucionController;
use App\Http\Controllers\Materia\MateriaController;
use App\Http\Controllers\Simulacro\SimulacroController;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('login-simulador', [AuthController::class, 'loginSimulador']);
});

// Protected routes
Route::middleware('jwt.verify')->group(function () {

    Route::prefix('users')->group(function () {
        Route::group(['middleware' => ['cors']], function () {
        });
        Route::post('/', [UserController::class, 'index']);
        Route::post('create', [UserController::class, 'create']);
        Route::put('modify/{id}', [UserController::class, 'modifyUser']);
        Route::post('estado', [UserController::class, 'estado']);
        Route::post('by-id', [UserController::class, 'byid']);
        Route::post('upload', [UserController::class, 'upload']);

        Route::put('update/{id}', [UserController::class, 'update']);
        Route::post('resetear', [UserController::class, 'resetear']);
        Route::post('cambiar', [UserController::class, 'cambiar']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });

    Route::prefix('roles')->group(function () {
        Route::post('/', [RoleController::class, 'index']);
    });

    Route::prefix('instituciones')->group(function () {
        Route::post('/', [InstitucionController::class, 'index']);
        Route::post('create', [InstitucionController::class, 'create']);
        Route::put('modify/{id}', [InstitucionController::class, 'modify']);
        Route::post('by-id', [InstitucionController::class, 'byid']);
        Route::post('estado', [InstitucionController::class, 'estado']);
        Route::post('upload', [InstitucionController::class, 'upload']);
        Route::post('activas', [InstitucionController::class, 'activas']);
    });

    Route::prefix('generales')->group(function () {
        Route::post('/departamentos', [GeneralController::class, 'departamentos']);
        Route::post('/municipios', [GeneralController::class, 'municipios']);
        Route::post('/grados', [GeneralController::class, 'grados']);
        Route::post('/cursos', [GeneralController::class, 'cursos']);
        Route::post('/tipo-documentos', [GeneralController::class, 'tipodocs']);
        Route::post('/sesiones', [GeneralController::class, 'sesiones']);
        Route::post('/simulacros', [GeneralController::class, 'simulacros']);
        Route::post('/componentes', [GeneralController::class, 'componentes']);
        Route::post('/cargar-dashboard', [GeneralController::class, 'dashboard']);
        Route::post('/competencias', [GeneralController::class, 'competencias']);
    });

    Route::prefix('materias')->group(function () {
        Route::post('/', [MateriaController::class, 'materias']);
        Route::post('/preguntas-materia', [MateriaController::class, 'preguntasMateria']);
        Route::post('estado', [MateriaController::class, 'estado']);
        Route::post('by-id', [MateriaController::class, 'byid']);
    });

    Route::prefix('preguntas')->group(function () {
        Route::post('create', [MateriaController::class, 'create']);
        Route::post('modify', [MateriaController::class, 'modify']);
    });

    Route::prefix('simulacros')->group(function () {
        Route::post('/', [SimulacroController::class, 'simulacros']);
        Route::post('sesiones', [SimulacroController::class, 'sesiones']);
        Route::post('sesiones-materias', [SimulacroController::class, 'sesionesMaterias']);
        Route::post('preguntas', [SimulacroController::class, 'preguntas']);
        Route::post('preguntas2', [SimulacroController::class, 'preguntas2']);
        Route::post('guardar-resultados', [SimulacroController::class, 'guardarResultados']);
        Route::post('verificar-prueba', [SimulacroController::class, 'verificarPrueba']);
        Route::post('verificar-sesion', [SimulacroController::class, 'verificarSesion']);
        Route::post('verificar-resultado-sesiones', [SimulacroController::class, 'verificarResultadoSesiones']);
    });

    Route::prefix('informes')->group(function () {
        Route::post('/resultados', [GeneralController::class, 'resultados']);
        Route::post('/resultados-institucion', [GeneralController::class, 'resultadosInstitucion']);
    });
});
