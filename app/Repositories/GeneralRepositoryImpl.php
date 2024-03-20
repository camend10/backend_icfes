<?php

namespace App\Repositories;

use App\Interfaces\GeneralRepository;
use App\Models\Componente;
use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Grado;
use App\Models\Municipio;
use App\Models\Sesion;
use App\Models\Simulacro;
use App\Models\TipoDocumento;

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
        return Grado::all();
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
}
