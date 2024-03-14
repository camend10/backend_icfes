<?php

namespace App\Repositories;

use App\Interfaces\InstitucionRepository;
use App\Models\Institucion;

class InstitucionRepositoryImpl implements InstitucionRepository
{
    public function getInstitucionAll()
    {
        return Institucion::where('estado', 1)->get();
    }

    public function getInstitucionById($id)
    {
        return Institucion::where('id', $id)
            ->first();
    }

    public function createInstitucion(array $institucion)
    {
        return Institucion::create($institucion);
    }

    public function estadoInstitucion($id, string $valor)
    {
        return Institucion::where(['id' => $id])->update([
            'estado' => $valor
        ]);
    }

    public function updateImgById($id, string $filename)
    {
        return Institucion::where(['id' => $id])->update([
            'foto' => $filename
        ]);
    }

    public function getInstituciones($txtbusqueda)
    {
        return Institucion::when($txtbusqueda, function ($sql) use ($txtbusqueda) {
            $sql->where('nombre', 'LIKE', '%' . $txtbusqueda . '%')
                ->orWhere('codigo', 'LIKE', '%' . $txtbusqueda . '%')
                ->orWhere('nit', 'LIKE', '%' . $txtbusqueda . '%');
        })
            ->get();
    }

    public function modifyInstitucion(array $institucion, $id)
    {
        return Institucion::whereId($id)->update($institucion);
    }
}
