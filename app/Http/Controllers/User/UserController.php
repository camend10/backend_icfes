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
                'error' => "El usuario no fue creado"
            ], 500);
        }
    }

    public function modifyUser(RegisterRequest $request, $id)
    {

        if (auth()->user()->role_id != 1) {
            return response()->json([
                'ok' => false,
                'errors' => "El usuario no tiene permisos para realizar esta operación"
            ], 500);
        }

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
                'error' => "El usuario no fue modificado"
            ], 500);
        }
    }

    public function index()
    {
        $txtbusqueda = request()->get('txtbusqueda');
        $users = $this->userService->getUsers($txtbusqueda);
        if($users) {
            return response()->json([
                'ok' => true,
                'users' => $users,
                'total' => $users->count()
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }

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
                'error' => "El usuario no fue modificado"
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
                        'error' => "La imagen no fue subida"
                    ], 500);
                }
            } else {
                return response()->json([
                    'ok' => false,
                    'error' => "La imagen no fue subida"
                ], 500);
            }
        }
    }

    public function estado()
    {
        if (auth()->user()->role_id != 1) {
            return response()->json([
                'ok' => false,
                'errors' => "El usuario no tiene permisos para realizar esta operación"
            ], 500);
        }

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
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }

    public function resetear()
    {

        if (auth()->user()->role_id != 1) {
            return response()->json([
                'ok' => false,
                'errors' => "El usuario no tiene permisos para realizar esta operación"
            ], 500);
        }

        $id = request()->get('id');
        $password = "12345678";
        $user = $this->userService->resetearUser($id, $password);        
        if ($user) {
            $user = $this->userService->getUserById($id);
            return response()->json([
                'ok' => true,
                'user' => $user,
                'mensaje' => "Clave reseteada al usuario: " . $user->name
            ], 201);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "La clave no se pudo resetear"
            ], 500);
        }
    }

    public function byid()
    {
        $id = request()->get('id');
        $user = $this->userService->getUserById($id);
        if ($user) {
            return response()->json([
                'ok' => true,
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "No existe usuario con este id: " . $id
            ], 500);
        }
    }

    public function cambiar(Request $request)
    {

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!\Illuminate\Support\Facades\Hash::check($value, auth()->user()->password)) {
                        return $fail(__('La clave actual es incorrecta'));

                        // return (object) ['ok' => false,'error' => $error];
                        // return response()->json([
                        //     'ok' => false,
                        //     'error' => $error
                        // ], 500);
                    }
                }
            ],
            'newpassword' => 'required|min:8|max:20',
            'confirmpassword' => 'required|same:newpassword'
        ], [
            'password.required' => 'La clave actual es requerida',
            'newpassword.required' => 'La nueva clave es requerida',
            'newpassword.min' => 'La nueva clave debe tener al menos 8 caracteres',
            'newpassword.max' => 'La nueva clave no debe tener más de 20 caracteres.',
            'confirmpassword.required' => 'vuelve a ingresar tu nueva clave',
            'confirmpassword.same' => 'No coincide con la nueva clave',
        ]);

        if (!$validator->passes()) {

            return response()->json([
                'error' => $validator->errors()->toArray()
            ], 500);
        } else {
            $id = request()->get('id');
            $password = request()->get('newpassword');
            $cambiar = $this->userService->resetearUser($id, $password);
            if (!$cambiar) {
                return response()->json([
                    'ok' => false,
                    'error' => "Algo salió mal, no se pudo actualizar la clave"
                ], 500);
            } else {
                return response()->json([
                    'ok' => true,
                    'mensaje' => "Tu clave ha sido cambiada exitosamente"
                ], 201);
            }
        }
    }
}
