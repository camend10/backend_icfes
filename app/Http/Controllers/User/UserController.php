<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Usuarios\UpdatePerfilRequest;
use App\Models\User;
use App\Services\UserService;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function create(RegisterRequest $request)
    {

        $user = $this->userService->createUser($request->validated());
        if ($user) {
            return response()->json([
                'ok' => true,
                'user' => $user
            ], 201);
        } else {
            return response()->json([
                'ok' => false,
                'errors' => "El usuario no fue creado"
            ], 500);
        }
    }

    public function modifyUser(RegisterRequest $request, $id)
    {

        $user = $this->userService->modifyUser($request->validated(), $id);
        if ($user) {
            $user = $this->userService->getUserById($id);
            return response()->json([
                'ok' => true,
                'user' => $user
            ], 201);
        } else {
            return response()->json([
                'ok' => false,
                'errors' => "El usuario no fue modificado"
            ], 500);
        }
    }


    public function index()
    {
        $txtbusqueda = request()->get('txtbusqueda');
        $users = $this->userService->getUsers($txtbusqueda);

        return response()->json([
            'ok' => true,
            'users' => $users,
            'total' => $users->count()
        ], 200);
    }

    public function update(UpdatePerfilRequest $request, $id)
    {
        $user = $this->userService->updateUser($request->validated(), $id);
        if ($user) {
            $user = $this->userService->getUserById($id);
            $actual = Carbon::now();
            $edad = $actual->diffInYears($user->fecha_nacimiento, $actual);
            return response()->json([
                'ok' => true,
                'user' => $user,
                'edad' => $edad
            ], 201);
        } else {
            return response()->json([
                'ok' => false,
                'errors' => "El usuario no fue modificado"
            ], 500);
        }
    }

    public function upload(Request $request)
    {

        $data = $request->all();

        switch ($data["tipo"]) {
            case "tipo_usuario":
                $tipo = "Usuario";
                break;
            case "tipo_docente":
                $tipo = "Docente";
                break;
            case "tipo_estudiante":
                $tipo = "Estudiante ";
                break;
            case "tipo_admin":
                $tipo = "Admin";
                break;
        }

        if (isset($data["archivo"])) {
            $filename = time() . "_" . $data["id"] . "_avatar." . $data["archivo"]->extension();

            $carpeta1 = glob(public_path('imagenes/foto/' . $tipo . '/' . $data["id"] . "/*"));
            foreach ($carpeta1 as $archivo) {
                if (is_file($archivo)) {
                    unlink($archivo);
                }
            }
            $mover = $request->archivo->move(public_path('imagenes/foto/' . $tipo . '/' . $data["id"]), $filename);

            if ($mover) {
                $user = $this->userService->updateImgById($data["id"], $filename);
                if ($user) {
                    $user = $this->userService->getUserById($data["id"]);
                    return response()->json([
                        'ok' => true,
                        'user' => $user,
                    ], 200);
                } else {
                    return response()->json([
                        'ok' => false,
                        'errors' => "La imagen no fue subida"
                    ], 500);
                }
            } else {
                return response()->json([
                    'ok' => false,
                    'errors' => "La imagen no fue subida"
                ], 500);
            }
        }
    }

    public function estado()
    {
        $id = request()->get('id');
        $estado = request()->get('estado');

        if ($estado == 1) {
            $mensaje = "Usuario eliminado de manera exitosa";
            $valor = 0;
        } else {
            $mensaje = "Usuario activado de manera exitosa";
            $valor = 1;
        }

        $user = $this->userService->estadoUser($id, $valor);
        if ($user) {
            $user = $this->userService->getUserById($id);
            return response()->json([
                'ok' => true,
                'user' => $user,
                'mensaje' => $mensaje
            ], 201);
        } else {
            return response()->json([
                'ok' => false,
                'errors' => $mensaje
            ], 500);
        }
    }

    public function byid()
    {
        $id = request()->get('id');
        $user = $this->userService->getUserById($id);

        return response()->json([
            'ok' => true,
            'user' => $user
        ], 200);
    }
}
