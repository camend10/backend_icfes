<?php

namespace App\Http\Controllers\Simulacro;

use App\Http\Controllers\Controller;
use App\Http\Requests\Resultados\ResultadoRequest;
use App\Services\GeneralService;
use App\Services\MateriaService;
use App\Services\SimulacroService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimulacroController extends Controller
{
    protected $simulacroService;
    protected $materiaService;
    protected $userService;
    protected $generalService;

    public function __construct(GeneralService $generalService,SimulacroService $simulacroService, MateriaService $materiaService, UserService $userService)
    {
        $this->simulacroService = $simulacroService;
        $this->materiaService = $materiaService;
        $this->userService = $userService;
        $this->generalService = $generalService;
    }

    public function simulacros()
    {
        $simulacros = $this->simulacroService->getSimulacros();
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
        $sesiones = $this->simulacroService->getSesiones();
        if ($sesiones) {
            return response()->json([
                'ok' => true,
                'sesiones' => $sesiones
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }

    public function sesionesMaterias()
    {
        $sesion_id = request()->get('sesion_id');
        $sesionMateria = $this->simulacroService->getSesionMateria($sesion_id);

        $materias = [];
        foreach ($sesionMateria as $sema) {
            $sema->materias->numpre = $sema->num_pregunta;
            $materias[] = $sema->materias;
        }

        if ($sesionMateria) {
            return response()->json([
                'ok' => true,
                'materias' => $materias
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }

    public function preguntas()
    {
        $materia_id = request()->get('materia_id');
        $sesion_id = request()->get('sesion_id');
        $preguntas = $this->simulacroService->getPreguntas($materia_id, $sesion_id);
        $materia = $this->materiaService->getMateriaById($materia_id);
        $sesion = $this->simulacroService->getSesionById($sesion_id);

        if ($preguntas) {
            return response()->json([
                'ok' => true,
                'preguntas' => $preguntas,
                'materia' => $materia->test_name,
                'tiempoTotal' => $sesion->tiempo
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }

    public function preguntas2()
    {
        $materia_id = request()->get('materia_id');
        $numpre = request()->get('numpre');
        $preguntas = $this->simulacroService->getPreguntas2($materia_id, $numpre);
        $materia = $this->materiaService->getMateriaById($materia_id);
        if ($preguntas) {
            return response()->json([
                'ok' => true,
                'preguntas' => $preguntas,
                'materia' => $materia->test_name
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }

    public function guardarResultados(ResultadoRequest $request)
    {
        $data = $request->validated();
        $totalPreguntas = $this->simulacroService->getTotalPreguntas($data['materia_id']);
        $puntaje = ($data['correctas'] / $totalPreguntas) * 100;

        $datos = [
            'simulacro_id' => $data['simulacro_id'],
            'sesion_id' => $data['sesion_id'],
            'user_id' => $data['user_id'],
            'materia_id' => $data['materia_id'],
            'estado' => 1,
            'puntaje' => $puntaje,
            'respCorreptasIds' => $data['respCorreptasIds'],
            'respCorreptasIdsValues' => $data['respCorreptasIdsValues'],
        ];

        $resultado = $this->simulacroService->createResultado($datos);
        if ($resultado) {
            $resultadoPreguntas = $this->simulacroService->createResultadoPreguntas($datos);
            return response()->json([
                'ok' => true,
                'resultado' => $resultado
            ], 201);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "No se guardarón los resultados"
            ], 500);
        }
    }

    public function verificarPrueba()
    {
        $datos = [
            'simulacro_id' => request()->get('simulacro_id'),
            'sesion_id' => request()->get('sesion_id'),
            'user_id' => request()->get('user_id'),
            'materia_id' => request()->get('materia_id'),
            'estado' => 1
        ];

        $resultado = $this->simulacroService->verificarResultado($datos);
        if ($resultado) {
            return response()->json([
                'ok' => true,
                'resultado' => $resultado->count(),
            ], 201);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "No se pudo verificar la prueba"
            ], 500);
        }
    }

    public function verificarSesion()
    {
        $datos = [
            'simulacro_id' => request()->get('simulacro_id'),
            'sesion_id' => request()->get('sesion_id'),
            'user_id' => request()->get('user_id'),
            'estado' => 1
        ];

        $resultado = $this->simulacroService->verificarSesion($datos);
        if ($resultado) {
            $totalMaterias = $this->simulacroService->getTotalMaterias($datos['sesion_id']);
            return response()->json([
                'ok' => true,
                'resultado' => $resultado->count(),
                'totalMaterias' => $totalMaterias
            ], 201);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "No se pudo verificar la prueba"
            ], 500);
        }
    }

    public function verificarResultadoSesiones()
    {
        $datos = [
            'user_id' => request()->get('user_id'),
            'simulacro_id' => request()->get('simulacro_id'),
            'estado' => 1
        ];

        $totalSesionesMaterias = $this->simulacroService->getTotalSesionesMaterias();
        $getPuntajes = $this->simulacroService->verificarPuntaje($datos);
        if ($totalSesionesMaterias > 0 && $getPuntajes >= 0) {
            if ($totalSesionesMaterias == $getPuntajes) {
                $user = $this->userService->getUserById($datos['user_id']);

                // PUNTAJE GLOBAL
                $getPun = $this->simulacroService->getPuntaje($datos);
                $suma = 0;
                $sumPesos = 0;
                $contador = 0;
                $fecha = "";
                foreach ($getPun as $vec) {
                    $suma = $suma + ($vec->peso * $vec->puntaje_total);
                    $sumPesos = $sumPesos + $vec->peso;
                    $contador++;
                    $fecha = substr($vec->fecha, 0, 10);
                }

                $global = ($suma / $sumPesos) * $contador;
                $global = round($global, 2);
                // PUNTAJE GLOBAL

                $institucion = $this->simulacroService->getInstitucion();
                $datos['grado_id'] = $user->grado_id;
                $totalEstudiantes = $this->simulacroService->getEstudiantesByResultado($datos);

                $totalPreguntas = $this->simulacroService->totalSumPreguntas();

                // PUESTO
                $puesto = $this->puesto($datos, $datos['user_id']);
                // PUESTO

                // ESTADISTICAS ESTUDIANTES
                $datos['materia_id'] = 1;
                $resComponentesMatematicas = $this->simulacroService->getResultadoComponentes($datos);

                $datos['materia_id'] = 2;
                $resComponentesLenguaje = $this->simulacroService->getResultadoComponentes($datos);

                $datos['materia_id'] = 3;
                $resComponentesSociales = $this->simulacroService->getResultadoComponentes($datos);

                $datos['materia_id'] = 4;
                $resComponentesNaturales = $this->simulacroService->getResultadoComponentes($datos);

                $datos['materia_id'] = 5;
                $resComponentesIngles = $this->simulacroService->getResultadoComponentes($datos);


                $datos['materia_id'] = 1;
                $resCompetenciasMatematicas = $this->simulacroService->getResultadoCompetencias($datos);

                $datos['materia_id'] = 2;
                $resCompetenciasLenguaje = $this->simulacroService->getResultadoCompetencias($datos);

                $datos['materia_id'] = 3;
                $resCompetenciasSociales = $this->simulacroService->getResultadoCompetencias($datos);

                $datos['materia_id'] = 4;
                $resCompetenciasNaturales = $this->simulacroService->getResultadoCompetencias($datos);

                $datos['materia_id'] = 5;
                $resCompetenciasIngles = $this->simulacroService->getResultadoCompetencias($datos);

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

                // MAXIMOS Y MINIMOS                
                $maxmintotal = $this->simulacroService->getPuntajesTotalMaximosMinimos($datos);                

                // Crear un array asociativo para almacenar los datos
                $maxminData = [];

                // Inicializar los arrays de datos para cada tipo de puntaje
                $puntajeMaximo = [];
                $puntajeEstudiante = [];
                $puntajePromedio = [];
                $puntajeMinimo = [];

                // Iterar sobre los resultados de la consulta y agregar los datos a los arrays correspondientes
                $materias = [];
                foreach ($maxmintotal as $resultado) {
                    $materias[] = $resultado->materia;
                    $puntajeMaximo[] = round($resultado->puntaje_maximo, 2);
                    $puntajeEstudiante[] = round($resultado->puntaje_estudiante, 2);
                    $puntajePromedio[] =  round($resultado->puntaje_promedio, 2);
                    $puntajeMinimo[] =  round($resultado->puntaje_minimo, 2);
                }

                // Agregar los arrays de datos al array $maxminData
                $maxminData[] = ['name' => 'Puntaje Máximo', 'data' => $puntajeMaximo];
                $maxminData[] = ['name' => 'Puntaje Estudiante', 'data' => $puntajeEstudiante];
                $maxminData[] = ['name' => 'Puntaje Promedio', 'data' => $puntajePromedio];
                $maxminData[] = ['name' => 'Puntaje Mínimo', 'data' => $puntajeMinimo];

                // dd($maxminData);die;
                // MAXIMOS Y MINIMOS

                // GRADO VS CURSO VS ESTUDIANTE
                // Inicializar los arrays de datos para cada tipo de puntaje
                $puntajeGrado = [];
                $puntajeEstu = [];
                $puntajeCurso = [];

                $datos['curso_id'] = $user->curso_id;
                $gracurest = $this->simulacroService->getPuntajesTotalMaximosMinimosCursos($datos);

                $datos['curso_id'] = "0";
                $gracurestGrado = $this->generalService->getConsultaTotalPromedios2($datos);
                foreach ($gracurestGrado as $resultado) {
                    $puntajeGrado[] =  round($resultado->puntaje_promedio, 2);
                }

                // Crear un array asociativo para almacenar los datos
                $gradoCursoEstudiante = [];


                // Iterar sobre los resultados de la consulta y agregar los datos a los arrays correspondientes
                foreach ($gracurest as $resultado) {
                    $puntajeEstu[] = round($resultado->puntaje_estudiante, 2);
                    $puntajeCurso[] =  round($resultado->puntaje_promedio, 2);
                }

                // Agregar los arrays de datos al array $maxminData
                // $gradoCursoEstudiante[] = ['name' => 'Grado', 'value' => $puntajePromedio];    
                $gradoCursoEstudiante[] = ['name' => 'Grado', 'value' => $puntajeGrado];            
                $gradoCursoEstudiante[] = ['name' => 'Estudiante', 'value' => $puntajeEstu];
                $gradoCursoEstudiante[] = ['name' => 'Curso', 'value' => $puntajeCurso];

                // dd($gradoCursoEstudiante);
                // die;


                $materiasMax = [];
                foreach ($materias as $index => $resp) {
                    $materiasMax[] = ['name' => $resp, 'max' => 100];
                }
                // GRADO VS CURSO VS ESTUDIANTE

                // PROMEDIO CURSO VS PUNTAJE ESTUDIANTE

                // Crear un array asociativo para almacenar los datos
                $cursoEstudiante = [];        

                // Agregar los arrays de datos al array $maxminData
                $cursoEstudiante[] = ['name' => 'Promedio Curso', 'data' => $puntajeCurso];
                $cursoEstudiante[] = ['name' => 'Promedio Estudiante', 'data' => $puntajeEstu];
                // PROMEDIO CURSO VS PUNTAJE ESTUDIANTE

                return response()->json([
                    'ok' => true,
                    'resultado' => true,
                    'user' => $user,
                    'puntaje' => $getPun,
                    'global' => $global,
                    'fecha' => $fecha,
                    'contador' => $contador,
                    'institucion' => $institucion,
                    'totalEstudiantes' => $totalEstudiantes,
                    'totalPreguntas' => $totalPreguntas,
                    'puesto' => $puesto,
                    'resComp' => $resComp,
                    'maxminData' => $maxminData,
                    'materias' => $materias,
                    'gradoCursoEstudiante' => $gradoCursoEstudiante,
                    'materiasMax' => $materiasMax,
                    'cursoEstudiante' => $cursoEstudiante

                ], 201);
            } else {
                return response()->json([
                    'ok' => true
                ], 201);
            }
        } else {
            return response()->json([
                'ok' => false,
                'error' => "No se pudo verificar el simulacro"
            ], 500);
        }
    }

    private function puesto($datos, $user_id)
    {
        $getUsers = $this->simulacroService->getUsersSimulacrosByResultado($datos);

        $puntajes_globales = [];

        // Calcular el puntaje global para cada usuario
        foreach ($getUsers as $usuario) {
            $datos['user_id'] = $usuario->id;

            $getPun = $this->simulacroService->getPuntaje($datos);
            $suma = 0;
            $sumPesos = 0;
            $contador = 0;

            foreach ($getPun as $vec) {
                $suma += $vec->peso * $vec->puntaje_total;
                $sumPesos += $vec->peso;
                $contador++;
            }

            // Calcular el puntaje global para el usuario actual
            $puntaje_global = ($suma / $sumPesos) * $contador;

            // Almacenar el puntaje global en el vector
            $puntajes_globales[$usuario->id] = $puntaje_global;
            // $puntajes_globales[] = $puntaje_global;

            // dd($puntaje_global);
            // die;
        }

        // Ordenar los puntajes globales de mayor a menor
        arsort($puntajes_globales);

        // dd($puntajes_globales);
        // die;

        // Encontrar el índice del puntaje global del usuario dado en la lista ordenada

        $indice = array_search($user_id, array_keys($puntajes_globales));

        // Calcular el puesto del usuario
        $puesto = $indice + 1;

        // Encontrar el puntaje máximo en el vector de puntajes globales
        $puntaje_maximo = max($puntajes_globales);

        return $puesto;
    }
}
