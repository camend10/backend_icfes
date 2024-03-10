<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $txtbusqueda = request()->get('txtbusqueda');
        $roles = $this->roleService->getRoles($txtbusqueda);

        return response()->json([
            'ok' => true,
            'roles' => $roles,
            'total' => $roles->count()
        ], 200);
    }
}
