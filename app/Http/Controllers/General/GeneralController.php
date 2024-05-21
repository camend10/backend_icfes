<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use App\Services\SimulacroService;
use App\Services\UserService;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    protected $generalService;
    protected $userService;
    protected $simulacroService;

    public function __construct(GeneralService $generalService, UserService $userService, SimulacroService $simulacroService)
    {
        $this->generalService = $generalService;
        $this->userService = $userService;
        $this->simulacroService = $simulacroService;
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

    public function resultados()
    {
        $datos = [
            'grado_id' => request()->get('grado_id'),
            'simulacro_id' => request()->get('simulacro_id'),
            'institucion_id' => request()->get('institucion_id'),
            'curso_id' => request()->get('curso_id'),
            'estado' => 1
        ];

        $usuarios = $this->generalService->getPuntajesGlobalEstudiante($datos);
        if ($usuarios) {
            return response()->json([
                'ok' => true,
                'usuarios' => $usuarios
            ], 201);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "No se pudo consultar el resultado"
            ], 500);
        }
    }

    public function resultadosInstitucion()
    {
        $datos = [
            'grado_id' => request()->get('grado_id'),
            'simulacro_id' => request()->get('simulacro_id'),
            'institucion_id' => request()->get('institucion_id'),
            'curso_id' => request()->get('curso_id'),
            'user_id' => 2,
            'estado' => 1
        ];

        $institucion = $this->simulacroService->getInstitucion2($datos);
        $totalEstudiantes = $this->simulacroService->getEstudiantesByResultado($datos);
        $totalPreguntas = $this->simulacroService->totalSumPreguntas();

        $respu = $this->generalService->getPuntajesGlobalInstitucion($datos);

        $global = 0;
        $contador = 0;
        if ($respu) {
            $global = round($respu->promedio_total, 2);
            $contador = $respu->contador + 1;
        }

        $puestosCursos = $this->generalService->getPuntajesGlobalInstitucionPuestos($datos);

        $getPun = $this->generalService->getPuntajesGlobalMateriasInstitucion($datos);

        // MAXIMOS Y MINIMOS
        $maxmintotal = $this->generalService->getConsultaTotalPromedios($datos);

        // Crear un array asociativo para almacenar los datos
        $maxminData = [];

        // Inicializar los arrays de datos para cada tipo de puntaje
        $puntajeMaximo = [];
        $puntajePromedio = [];
        $puntajeMinimo = [];

        // Iterar sobre los resultados de la consulta y agregar los datos a los arrays correspondientes
        $materias = [];
        foreach ($maxmintotal as $resultado) {
            $materias[] = $resultado->materia;
            $puntajeMaximo[] = round($resultado->gran_puntaje_maximo, 2);
            $puntajePromedio[] =  round($resultado->gran_prom_total, 2);
            $puntajeMinimo[] =  round($resultado->gran_puntaje_minimo, 2);
        }

        // Agregar los arrays de datos al array $maxminData
        $maxminData[] = ['name' => 'Puntaje Máximo', 'data' => $puntajeMaximo];
        $maxminData[] = ['name' => 'Puntaje Promedio', 'data' => $puntajePromedio];
        $maxminData[] = ['name' => 'Puntaje Mínimo', 'data' => $puntajeMinimo];
        // MAXIMOS Y MINIMOS


        // ESTADISTICAS ESTUDIANTES
        $datos['materia_id'] = 1;
        $resComponentesMatematicas = $this->generalService->getResultadoComponentesGlobal($datos);

        $datos['materia_id'] = 2;
        $resComponentesLenguaje = $this->generalService->getResultadoComponentesGlobal($datos);

        $datos['materia_id'] = 3;
        $resComponentesSociales = $this->generalService->getResultadoComponentesGlobal($datos);

        $datos['materia_id'] = 4;
        $resComponentesNaturales = $this->generalService->getResultadoComponentesGlobal($datos);

        $datos['materia_id'] = 5;
        $resComponentesIngles = $this->generalService->getResultadoComponentesGlobal($datos);


        $datos['materia_id'] = 1;
        $resCompetenciasMatematicas = $this->generalService->getResultadoCompetenciasGlobal($datos);

        $datos['materia_id'] = 2;
        $resCompetenciasLenguaje = $this->generalService->getResultadoCompetenciasGlobal($datos);

        $datos['materia_id'] = 3;
        $resCompetenciasSociales = $this->generalService->getResultadoCompetenciasGlobal($datos);

        $datos['materia_id'] = 4;
        $resCompetenciasNaturales = $this->generalService->getResultadoCompetenciasGlobal($datos);

        $datos['materia_id'] = 5;
        $resCompetenciasIngles = $this->generalService->getResultadoCompetenciasGlobal($datos);

        $resComp = [
            'resComponentesMatematicas' => $resComponentesMatematicas,
            'resComponentesLenguaje' => $resComponentesLenguaje,
            'resComponentesSociales' => $resComponentesSociales,
            'resComponentesNaturales' => $resComponentesNaturales,
            'resComponentesIngles' => $resComponentesIngles,

            'resCompetenciasMatematicas' => $resCompetenciasMatematicas,
            'resCompetenciasLenguaje' => $resCompetenciasLenguaje,
            'resCompetenciasSociales' => $resCompetenciasSociales,
            'resCompetenciasNaturales' => $resCompetenciasNaturales,
            'resCompetenciasIngles' => $resCompetenciasIngles,
        ];


        // ESTADISTICAS ESTUDIANTES

        // GRADO VS CURSO
        $gracurest = [];
        // Crear un array asociativo para almacenar los datos
        $gradoCursoEstudiante = [];

        // Crear un array asociativo para almacenar los datos
        $cursoEstudiante = [];
        if ($datos['curso_id'] != "0") {
            // Inicializar los arrays de datos para cada tipo de puntaje
            $puntajeGrado = [];
            $puntajeCurso = [];

            $gracurest = $this->generalService->getConsultaTotalPromedios($datos);
            $datos['curso_id'] = "0";
            $gracurestGrado = $this->generalService->getConsultaTotalPromedios($datos);


            foreach ($gracurestGrado as $resultado) {
                $puntajeGrado[] =  round($resultado->gran_prom_total, 2);
            }

            $gradoCursoEstudiante[] = ['name' => 'Grado', 'value' => $puntajeGrado];

            // Iterar sobre los resultados de la consulta y agregar los datos a los arrays correspondientes
            foreach ($gracurest as $resultado) {
                $puntajeCurso[] =  round($resultado->puntaje_promedio, 2);
            }

            // Agregar los arrays de datos al array $maxminData
            $gradoCursoEstudiante[] = ['name' => 'Curso', 'value' => $puntajeCurso];

            // PROMEDIO CURSO VS PUNTAJE ESTUDIANTE

            // Agregar los arrays de datos al array $maxminData
            $cursoEstudiante[] = ['name' => 'Promedio Grado', 'data' => $puntajeGrado];
            $cursoEstudiante[] = ['name' => 'Promedio Curso', 'data' => $puntajeCurso];
            // PROMEDIO CURSO VS PUNTAJE ESTUDIANTE
        }
        $materiasMax = [];
        foreach ($materias as $index => $resp) {
            $materiasMax[] = ['name' => $resp, 'max' => 100];
        }

        // GRADO VS CURSO


        if ($institucion) {
            return response()->json([
                'ok' => true,
                'institucion' => $institucion,
                'totalEstudiantes' => $totalEstudiantes,
                'totalPreguntas' => $totalPreguntas,
                'global' => $global,
                'contador' => $contador,
                'puntaje' => $getPun,
                'maxminData' => $maxminData,
                'materias' => $materias,
                'gradoCursoEstudiante' => $gradoCursoEstudiante,
                'materiasMax' => $materiasMax,
                'cursoEstudiante' => $cursoEstudiante,
                'resComp' => $resComp,
                'puestosCursos' => $puestosCursos
            ], 201);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "No se pudo consultar el resultado"
            ], 500);
        }
    }
}
