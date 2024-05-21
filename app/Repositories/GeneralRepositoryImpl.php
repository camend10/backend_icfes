<?php

namespace App\Repositories;

use App\Interfaces\GeneralRepository;
use App\Models\Competencia;
use App\Models\Componente;
use App\Models\ConsultaTotalPromedios;
use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Grado;
use App\Models\Municipio;
use App\Models\Pregunta;
use App\Models\PuntajeGlobalEstudiante;
use App\Models\PuntajeGlobalInstitucion;
use App\Models\PuntajeGlobalMateriasInstitucion;
use App\Models\PuntajeGlobalMaximoMinimoInstitucion;
use App\Models\PuntajeMaximoMinimoCurso;
use App\Models\ResultadoCompetenciasGlobal;
use App\Models\ResultadoComponentesGlobal;
use App\Models\Sesion;
use App\Models\Simulacro;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\DB;

class GeneralRepositoryImpl implements GeneralRepository
{
    public function getDepartamentos()
    {
        return Departamento::all();
    }

    public function getMunicipios()
    {
        return Municipio::all();
    }

    public function getTipoDocs()
    {
        return TipoDocumento::all();
    }

    public function cursos()
    {
        return Curso::all();
    }

    public function grados()
    {
        return Grado::where('estado', 'Activo')
            ->get();
    }

    public function simulacros()
    {
        return Simulacro::where('estado', 1)->get();
    }

    public function sesiones()
    {
        return Sesion::where('estado', 1)->get();
    }

    public function componentes($materia_id)
    {
        return Componente::where('estado', 1)
            ->where('materia_id', $materia_id)
            ->get();
    }

    public function getTotalPreguntas()
    {
        return Pregunta::where('estado', 1)
            ->get();
    }

    public function competencias($materia_id)
    {
        return Competencia::where('estado', 1)
            ->where('materia_id', $materia_id)
            ->get();
    }

    public function getPuntajesGlobalEstudiante(array $vector)
    {
        return PuntajeGlobalEstudiante::where('simulacro_id', $vector['simulacro_id'])
            ->where('grado_id', $vector['grado_id'])
            ->orderBy('puntaje_global', 'desc')
            ->when($vector['curso_id'], function ($sql) use ($vector) {
                $sql->where('curso_id', $vector['curso_id']);
            })
            ->with(
                'usuario',
                'grado',
                'curso'
            )
            ->whereHas('usuario', function ($query) use ($vector) {
                $query->where('institucion_id', $vector['institucion_id']);
            })
            ->get();
    }

    public function getPuntajesGlobalInstitucion(array $vector)
    {
        return PuntajeGlobalInstitucion::where('simulacro_id', $vector['simulacro_id'])
            ->where('grado_id', $vector['grado_id'])
            ->when($vector['curso_id'], function ($sql) use ($vector) {
                $sql->where('curso_id', $vector['curso_id']);
            })
            ->whereHas('usuario', function ($query) use ($vector) {
                $query->where('institucion_id', $vector['institucion_id']);
            })
            ->select(
                DB::raw('*,sum(promedio) / count(*) as promedio_total,sum(contador) as contador')
            )
            ->groupBy('simulacro_id')
            ->first();
    }

    public function getPuntajesGlobalMateriasInstitucion(array $vector)
    {
        return PuntajeGlobalMateriasInstitucion::where('simulacro_id', $vector['simulacro_id'])
            ->where('grado_id', $vector['grado_id'])
            ->when($vector['curso_id'], function ($sql) use ($vector) {
                $sql->where('curso_id', $vector['curso_id']);
            })
            ->whereHas('usuario', function ($query) use ($vector) {
                $query->where('institucion_id', $vector['institucion_id']);
            })
            ->select(
                DB::raw('*, avg(promedio_total) as gran_prom_total ')
            )
            ->groupBy('materia_id')
            ->get();
    }

    public function getPuntajesGlobalMaximoMinimoInstitucion(array $vector)
    {
        return PuntajeGlobalMaximoMinimoInstitucion::where('simulacro_id', $vector['simulacro_id'])
            ->where('grado_id', $vector['grado_id'])
            ->when($vector['curso_id'], function ($sql) use ($vector) {
                $sql->where('curso_id', $vector['curso_id']);
            })
            ->whereHas('usuario', function ($query) use ($vector) {
                $query->where('institucion_id', $vector['institucion_id']);
            })
            ->select(
                DB::raw('*,
                avg(promedio_total) as gran_prom_total,MAX(promedio_total) as gran_puntaje_maximo,MIN(promedio_total) as gran_puntaje_minimo')
            )
            ->groupBy('materia_id')
            ->get();
    }

    public function getPuntajeMaximoMinimoCurso(array $vector)
    {
        return PuntajeMaximoMinimoCurso::where('simulacro_id', $vector['simulacro_id'])
            ->where('grado_id', $vector['grado_id'])
            ->when($vector['curso_id'], function ($sql) use ($vector) {
                $sql->where('curso_id', $vector['curso_id']);
            })
            ->whereHas('usuario', function ($query) use ($vector) {
                $query->where('institucion_id', $vector['institucion_id']);
            })
            ->get();
    }

    public function getConsultaTotalPromedios(array $vector)
    {
        return ConsultaTotalPromedios::where('simulacro_id', $vector['simulacro_id'])
            ->where('grado_id', $vector['grado_id'])
            ->when($vector['curso_id'], function ($sql) use ($vector) {
                $sql->where('curso_id', $vector['curso_id']);
            })
            ->whereHas('usuario', function ($query) use ($vector) {
                $query->where('institucion_id', $vector['institucion_id']);
            })
            ->select(
                DB::raw('*,avg(puntaje_promedio) as gran_prom_total,MAX(puntaje_maximo) as gran_puntaje_maximo,MIN(puntaje_minimo) as gran_puntaje_minimo')
            )
            ->groupBy('materia_id')
            ->get();
    }

    public function getConsultaTotalPromedios2(array $vector)
    {
        return ConsultaTotalPromedios::where('simulacro_id', $vector['simulacro_id'])
            ->where('grado_id', $vector['grado_id'])
            ->when($vector['curso_id'], function ($sql) use ($vector) {
                $sql->where('curso_id', $vector['curso_id']);
            })
            ->select(
                DB::raw('materia,avg(puntaje_promedio) as puntaje_promedio,MAX(puntaje_maximo) as puntaje_maximo,MIN(puntaje_minimo) as puntaje_minimo')
            )
            ->groupBy('materia_id')
            ->get();
    }

    public function getResultadoComponentesGlobal(array $vector)
    {
        return ResultadoComponentesGlobal::where('simulacro_id', $vector['simulacro_id'])
            ->where('grado_id', $vector['grado_id'])
            ->where('materia_id', $vector['materia_id'])
            ->when($vector['curso_id'], function ($sql) use ($vector) {
                $sql->where('curso_id', $vector['curso_id']);
            })
            ->whereHas('usuario', function ($query) use ($vector) {
                $query->where('institucion_id', $vector['institucion_id']);
            })
            ->select(
                DB::raw('*, SUM(porcentaje )/count(*) AS porcentaje_global ')
            )
            ->groupBy('id')
            ->get();
    }

    public function getResultadoCompetenciasGlobal(array $vector)
    {
        return ResultadoCompetenciasGlobal::where('simulacro_id', $vector['simulacro_id'])
            ->where('grado_id', $vector['grado_id'])
            ->where('materia_id', $vector['materia_id'])
            ->when($vector['curso_id'], function ($sql) use ($vector) {
                $sql->where('curso_id', $vector['curso_id']);
            })
            ->whereHas('usuario', function ($query) use ($vector) {
                $query->where('institucion_id', $vector['institucion_id']);
            })
            ->select(
                DB::raw('*, SUM(porcentaje )/count(*) AS porcentaje_global ')
            )
            ->groupBy('id')
            ->get();
    }

    public function getPuntajesGlobalInstitucionPuestos(array $vector)
    {
        return PuntajeGlobalInstitucion::where('simulacro_id', $vector['simulacro_id'])
            ->where('grado_id', $vector['grado_id'])
            ->whereHas('usuario', function ($query) use ($vector) {
                $query->where('institucion_id', $vector['institucion_id']);
            })
            ->with(
                'usuario',
                'grado',
                'curso'
            )
            ->orderBy('promedio', 'desc')
            ->get();
    }
}
