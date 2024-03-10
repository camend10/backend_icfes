<?php

namespace App\Services;

use App\Interfaces\RoleRepository;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }


    public function getRoles($txtbusqueda)
    {
        return $this->roleRepository->getRoles($txtbusqueda);
    }
}
