<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use App\Services\UserService;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    protected $generalService;
    protected $userService;

    public function __construct(GeneralService $generalService, UserService $userService)
    {
        $this->generalService = $generalService;
        $this->userService = $userService;
    }

    public function departamentos()
    {
        $departamentos = $this->generalService->getDepartamentos();
        if ($departamentos) {
            return response()->json([
                'ok' => true,
                'departamentos' => $departamentos,
                'total' => $departamentos->count()
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }

    public function municipios()
    {
        $muni = $this->generalService->getMunicipios();

        $municipios = [];
        foreach ($muni as $item) {
            $municipios[$item->departamento_id][] = [
                'id' => $item->id,
                'nombre' => strtoupper($item->nombre),
            ];
        }
        if ($muni) {
            return response()->json([
                'ok' => true,
                'municipios' => $municipios,
                'total' => $muni->count()
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }

    public function tipodocs()
    {
        $tipodocumentos = $this->generalService->getTipoDocs();
        if ($tipodocumentos) {
            return response()->json([
                'ok' => true,
                'tipodocumentos' => $tipodocumentos,
                'total' => $tipodocumentos->count()
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }

    public function grados()
    {
        $grados = $this->generalService->grados();
        if ($grados) {
            return response()->json([
                'ok' => true,
                'grados' => $grados,
                'total' => $grados->count()
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }

    public function cursos()
    {
        $cursos = $this->generalService->cursos();
        if ($cursos) {
            return response()->json([
                'ok' => true,
                'cursos' => $cursos,
                'total' => $cursos->count()
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }

    public function simulacros()
    {
        $simulacros = $this->generalService->simulacros();
        if ($simulacros) {
            return response()->json([
                'ok' => true,
                'simulacros' => $simulacros,
                'total' => $simulacros->count()
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }

    public function sesiones()
    {
        $sesiones = $this->generalService->sesiones();
        if ($sesiones) {
            return response()->json([
                'ok' => true,
                'sesiones' => $sesiones,
                'total' => $sesiones->count()
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }

    public function componentes()
    {
        $materia_id = request()->get('materia_id');
        $componentes = $this->generalService->componentes($materia_id);
        if ($componentes) {
            return response()->json([
                'ok' => true,
                'componentes' => $componentes,
                'total' => $componentes->count()
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }

    public function dashboard()
    {
        $estudiantes = $this->userService->getUserByRol(3);
        $docentes = $this->userService->getUserByRol(4);
        $usuarios = $this->userService->getUserByRol(1);
        $preguntas = $this->generalService->getTotalPreguntas();


        $datos = [
            'estudiantes' => $estudiantes->count(),
            'docentes' => $docentes->count(),
            'usuarios' => $usuarios->count(),
            'preguntas' => $preguntas->count()
        ];
        if ($preguntas) {
            return response()->json([
                'ok' => true,
                'datos' => $datos
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }

    public function competencias()
    {
        $materia_id = request()->get('materia_id');
        $competencias = $this->generalService->competencias($materia_id);
        if ($competencias) {
            return response()->json([
                'ok' => true,
                'competencias' => $competencias,
                'total' => $competencias->count()
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }
}
