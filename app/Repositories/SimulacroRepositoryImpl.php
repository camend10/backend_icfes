<?php

namespace App\Repositories;

use App\Interfaces\SimulacroRepository;
use App\Models\Institucion;
use App\Models\Pregunta;
use App\Models\Puntaje;
use App\Models\PuntajeMateriaEstudiante;
use App\Models\PuntajeMaximoMinimo;
use App\Models\PuntajeTotalMaximoMinimo;
use App\Models\PuntajeTotalMaximoMinimoCurso;
use App\Models\Resultado;
use App\Models\ResultadoCompetencias;
use App\Models\ResultadoComponentes;
use App\Models\ResultadoPregunta;
use App\Models\Sesion;
use App\Models\SesionMateria;
use App\Models\Simulacro;
use Illuminate\Support\Facades\DB;

class SimulacroRepositoryImpl implements SimulacroRepository
{
    public function getSimulacros()
    {
        return Simulacro::where('estado', 1)->get();
    }

    public function getSimulacroById($id)
    {
        return Simulacro::where('id', $id)
            ->first();
    }

    public function getSesiones()
    {
        return Sesion::where('estado', 1)->get();
    }

    public function getSesionById($sesion_id)
    {
        return Sesion::where('estado', 1)
            ->where('id', $sesion_id)
            ->first();
    }

    public function getSesionMateria($sesion_id)
    {
        return SesionMateria::where('estado', 1)
            ->where('sesion_id', $sesion_id)
            ->with(
                'materias',
                'sesiones'
            )
            ->get();
    }

    public function getPreguntas($materia_id, $sesion_id)
    {
        $sesionMateria = SesionMateria::where('materia_id', $materia_id)
            ->where('sesion_id', $sesion_id)
            ->first();
        // $cantidad = $sesionMateria->num_pregunta;
        $cantidad = 5;
        $randomIds = Pregunta::inRandomOrder()
            ->where('estado', 1)
            ->where('test_id', $materia_id)
            ->take($cantidad)
            ->pluck('id');

        return Pregunta::whereIn('id', $randomIds)->get();
    }
    public function getPreguntas2($materia_id, $numpre)
    {
        $randomIds = Pregunta::inRandomOrder()
            ->where('estado', 1)
            ->where('test_id', $materia_id)
            ->take($numpre)
            // ->take(2)
            ->pluck('id');

        return Pregunta::whereIn('id', $randomIds)->get();
    }

    public function getTotalPreguntas($materia_id)
    {
        $totalPreguntas = SesionMateria::where('materia_id', $materia_id)
            ->where('estado', 1)
            ->sum('num_pregunta');
        return $totalPreguntas;
    }

    public function getTotalMaterias($sesion_id)
    {
        $totalMaterias = SesionMateria::where('sesion_id', $sesion_id)
            ->where('estado', 1)
            ->count('sesion_id');
        return $totalMaterias;
    }

    public function getTotalSesionesMaterias()
    {
        $totalSesionesMaterias = SesionMateria::where('estado', 1)
            ->count('id');
        return $totalSesionesMaterias;
    }

    public function createResultado(array $resultado)
    {
        return Resultado::create($resultado);
    }

    public function verificarResultado(array $resultado)
    {
        return Resultado::where('materia_id', $resultado['materia_id'])
            ->where('sesion_id', $resultado['sesion_id'])
            ->where('simulacro_id', $resultado['simulacro_id'])
            ->where('user_id', $resultado['user_id'])
            ->where('estado', 1)
            ->get();
    }

    public function verificarSesion(array $resultado)
    {
        return Resultado::where('sesion_id', $resultado['sesion_id'])
            ->where('simulacro_id', $resultado['simulacro_id'])
            ->where('user_id', $resultado['user_id'])
            ->where('estado', 1)
            ->get();
    }

    public function verificarPuntaje(array $vector)
    {
        return Puntaje::where('simulacro_id', $vector['simulacro_id'])
            ->where('user_id', $vector['user_id'])
            ->count('id');
    }

    public function getPuntaje(array $vector)
    {
        return Puntaje::where('simulacro_id', $vector['simulacro_id'])
            ->where('user_id', $vector['user_id'])
            ->select(
                'materia',
                'peso',
                'fecha',
                DB::raw('SUM(puntaje) as puntaje_total')
            )
            ->groupBy('materia_id')
            ->get();
    }

    public function getInstitucion()
    {
        return Institucion::where('estado', 1)->first();
    }

    public function createResultadoPreguntas(array $datos)
    {
        foreach ($datos['respCorreptasIds'] as $key => $id) {
            ResultadoPregunta::create([
                'user_id' => $datos['user_id'],
                'materia_id' => $datos['materia_id'],
                'simulacro_id' => $datos['simulacro_id'],
                'sesion_id' => $datos['sesion_id'],
                'estado' => $datos['estado'],
                'respuesta' => $datos['respCorreptasIdsValues'][$key],
                'pregunta_id' => $id
            ]);
        }
        return true;
    }

    public function getEstudiantesByResultado(array $datos)
    {
        return Puntaje::distinct('user_id')
            ->where('simulacro_id', $datos['simulacro_id'])
            ->where('grado_id', $datos['grado_id'])
            ->count();
    }

    public function totalSumPreguntas()
    {
        return SesionMateria::sum('num_pregunta');
    }

    public function getUsersSimulacrosByResultado(array $datos)
    {
        return Puntaje::distinct('user_id')
            ->where('simulacro_id', $datos['simulacro_id'])
            ->where('grado_id', $datos['grado_id'])
            ->select('user_id as id')
            ->get();
    }

    public function getResultadoComponentes(array $vector)
    {
        return ResultadoComponentes::where('simulacro_id', $vector['simulacro_id'])
            ->where('user_id', $vector['user_id'])
            ->where('materia_id', $vector['materia_id'])
            ->select(
                DB::raw('*, (percent*100/total) AS porcentaje')
            )
            ->groupBy('id')
            ->get();

        // return DB::select("SELECT *, (percent*100/total) AS porcentaje
        //     FROM resultado_componentes
        //     WHERE
        //         simulacro_id = " . $vector['simulacro_id'] . "
        //             AND
        //         user_id = " . $vector['user_id'] . "
        //             AND
        //         materia_id = " . $vector['materia_id'] . "
        //     GROUP BY id ORDER BY id;");
    }

    public function getResultadoCompetencias(array $vector)
    {
        return ResultadoCompetencias::where('simulacro_id', $vector['simulacro_id'])
            ->where('user_id', $vector['user_id'])
            ->where('materia_id', $vector['materia_id'])
            ->select(
                DB::raw('*, (percent*100/total) AS porcentaje')
            )
            ->groupBy('id')
            ->get();
    }

    public function getPuntajesMaximosMinimos(array $vector)
    {
        return PuntajeMaximoMinimo::where('simulacro_id', $vector['simulacro_id'])
            ->where('grado_id', $vector['grado_id'])
            ->get();
    }

    public function getPuntajesMateriaEstudiante(array $vector)
    {
        return PuntajeMateriaEstudiante::where('simulacro_id', $vector['simulacro_id'])
            ->where('user_id', $vector['user_id'])
            ->get();
    }

    public function getPuntajesTotalMaximosMinimos(array $vector)
    {
        return PuntajeTotalMaximoMinimo::where('simulacro_id', $vector['simulacro_id'])
            ->where('grado_id', $vector['grado_id'])
            ->where('user_id', $vector['user_id'])

            ->select(
                DB::raw('materia,MAX(puntaje_maximo) as puntaje_maximo,puntaje_estudiante,avg(puntaje_promedio) as puntaje_promedio,MIN(puntaje_minimo) as puntaje_minimo')
            )
            ->groupBy('materia_id')
            ->get();
    }

    public function getPuntajesTotalMaximosMinimosCursos(array $vector)
    {
        return PuntajeTotalMaximoMinimoCurso::where('simulacro_id', $vector['simulacro_id'])
            ->where('grado_id', $vector['grado_id'])
            ->where('curso_id', $vector['curso_id'])
            ->where('user_id', $vector['user_id'])
            ->get();
    }

    public function getInstitucion2(array $vector)
    {
        return Institucion::where('estado', 1)
            ->where('id', $vector['institucion_id'])
            ->first();
    }
}
