<?php

namespace App\Repositories;

use App\Interfaces\GeneralRepository;
use App\Models\Departamento;
use App\Models\Municipio;
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
}
