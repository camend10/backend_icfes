<?php

namespace App\Repositories;

use App\Interfaces\RoleRepository;
use App\Models\Role;

class RoleRepositoryImpl implements RoleRepository
{
    public function getRoles($txtbusqueda)
    {
        return Role::when($txtbusqueda, function ($sql) use ($txtbusqueda) {
            $sql->where('nombre', 'LIKE', '%' . $txtbusqueda . '%');
        })
            ->with(
                'usuarios'
            )
            ->get();
    }
}
