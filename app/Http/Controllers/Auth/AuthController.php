<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\UserService;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(LoginRequest $request)
    {
        // $credentials = $request->only('email', 'password');

        $user = $this->userService->getUserByEmail($request->email);
        if ($user) {
            if ($user->tipo == "tipo_estudiante") {
                return response()->json([
                    'error' => 'El usuario no tiene permisos para entrar a la plataforma'
                ], 401);
            } else {

                try {
                    if (!$token = JWTAuth::attempt([
                        "email" => $request->email,
                        "password" => $request->password,
                        "estado" => 1,
                        "tipo" => $user->tipo
                    ])) {
                        return response()->json([
                            'error' => 'Credenciales Invalidas'
                        ], 401);
                    }
                } catch (JWTException $e) {
                    return response()->json([
                        'error' => 'Error: Token no encontrado'
                    ], 500);
                }
                return $this->respondWithToken($token, $user);
            }
        } else {
            return response()->json([
                'error' => 'No existe usuario'
            ], 401);
        }
    }

    public function loginSimulador(Request $request)
    {
        $login = $request->input('username');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($field == 'email') {
            $user = $this->userService->getUserByEmail($request->username);
        } else {
            $user = $this->userService->getUserByUsername($request->username);
        }

        if ($user) {

            try {
                if (!$token = JWTAuth::attempt([
                    $field => $login,
                    "password" => $request->password,
                    "estado" => 1
                ])) {
                    return response()->json([
                        'error' => 'Credenciales Invalidas'
                    ], 401);
                }
            } catch (JWTException $e) {
                return response()->json([
                    'error' => 'Error: Token no encontrado'
                ], 500);
            }

            return $this->respondWithToken2($token, $user);
        } else {
            return response()->json([
                'error' => 'No existe usuario'
            ], 401);
        }
    }

    public function refresh()
    {
        // Intenta refrescar el token
        try {
            $token = JWTAuth::getToken(); // Obtiene el token actual
            $tokenRefreshed = JWTAuth::refresh($token); // Refresca el token
            JWTAuth::setToken($tokenRefreshed); // Reemplaza el token viejo con el nuevo
            $user = JWTAuth::authenticate($tokenRefreshed); // Obtiene el usuario asociado al token refrescado

            return $this->respondWithToken($tokenRefreshed, $user);
            // return response()->json([
            //     'success' => true,
            //     'token' => $tokenRefreshed, // Devuelve el token refrescado
            //     'user' => $user
            // ]);
        } catch (JWTException $e) {
            // No se pudo refrescar el token, posiblemente porque es inválido o ha expirado.
            return response()->json([
                'ok' => false,
                'error' => 'No se pudo refrescar el token.'
            ], 401);
        }
    }

    protected function respondWithToken($token, $user)
    {

        $actual = Carbon::now();
        $edad = $actual->diffInYears($user->fecha_nacimiento, $actual);

        // dd($user->roles->nombre);die;
        return response()->json([
            'ok' => true,
            'token' => $token,
            'token_type' => 'bearer',
            'expiresIn' => JWTAuth::factory()->getTTL(),
            'user' => $user,
            'edad' => $edad,
            // 'user' => auth()->user(),
            'id' => auth()->user()->id,
            'error' => false,
            'menu' => $this->obtenerMenu($user->rol->nombre)
        ], 200);
    }

    protected function respondWithToken2($token, $user)
    {

        $actual = Carbon::now();
        $edad = $actual->diffInYears($user->fecha_nacimiento, $actual);

        // dd($user->roles->nombre);die;
        return response()->json([
            'ok' => true,
            'token' => $token,
            'token_type' => 'bearer',
            'expiresIn' => JWTAuth::factory()->getTTL(),
            'user' => $user,
            'edad' => $edad,
            // 'user' => auth()->user(),
            'id' => auth()->user()->id,
            'error' => false,
            'menu' => $this->obtenerMenu2($user->rol->nombre)
        ], 200);
    }

    public function obtenerMenu($ROLE)
    {
        $menu = [];
        switch ($ROLE) {
            case "Admin":
                $menu = [
                    [
                        'titulo' => 'Usuarios',
                        'icono' => 'ki-duotone ki-profile-user',
                        'submenu' => [
                            ['titulo' => 'Gestión de usuarios', 'url' => '/usuarios'],
                            // ['titulo' => 'Roles', 'url' => '/login'],
                        ]
                    ],
                    [
                        'titulo' => 'Instituciones',
                        'icono' => 'ki-duotone ki-home',
                        'submenu' => [
                            ['titulo' => 'Gestión de instituciones', 'url' => '/instituciones']
                        ]
                    ],
                    [
                        'titulo' => 'Preguntas',
                        'icono' => 'ki-duotone ki-book',
                        'submenu' => [
                            ['titulo' => 'Gestión de preguntas', 'url' => '/preguntas'],
                        ]
                    ],
                    [
                        'titulo' => 'Informes',
                        'icono' => 'ki-duotone ki-file-added',
                        'submenu' => [
                            ['titulo' => 'Resultados', 'url' => '/informe-resultados'],
                            ['titulo' => 'Entrenamientos', 'url' => '/informe-entrenamientos'],
                            ['titulo' => 'Areas', 'url' => '/informe-areas'],
                            ['titulo' => 'Niveles', 'url' => '/informe-niveles'],
                            ['titulo' => 'Competencias', 'url' => '/informe-competencias'],
                        ]
                    ]
                ];
                break;
            case "Usuario":
                $menu = [
                    [
                        'titulo' => 'Informes',
                        'icono' => 'ki-duotone ki-file-added',
                        'submenu' => [
                            ['titulo' => 'Resultados', 'url' => '/informe-resultados'],
                            ['titulo' => 'Entrenamientos', 'url' => '/informe-entrenamientos'],
                            ['titulo' => 'Areas', 'url' => '/informe-areas'],
                            ['titulo' => 'Niveles', 'url' => '/informe-niveles'],
                            ['titulo' => 'Competencias', 'url' => '/informe-competencias'],
                        ]
                    ]
                ];
                break;
            case "Estudiante":
                $menu = [
                    [
                        'titulo' => 'Informes',
                        'icono' => 'ki-duotone ki-file-added',
                        'submenu' => [
                            ['titulo' => 'Informe general', 'url' => '/informe-general'],
                        ]
                    ]
                ];
                break;
            case "Docente":
                $menu = [
                    [
                        'titulo' => 'Informes',
                        'icono' => 'ki-duotone ki-file-added',
                        'submenu' => [
                            ['titulo' => 'Resultados', 'url' => '/informe-resultados'],
                            ['titulo' => 'Entrenamientos', 'url' => '/informe-entrenamientos'],
                            ['titulo' => 'Areas', 'url' => '/informe-areas'],
                            ['titulo' => 'Niveles', 'url' => '/informe-niveles'],
                            ['titulo' => 'Competencias', 'url' => '/informe-competencias'],
                        ]
                    ]
                ];
                break;
        }

        return $menu;
    }

    public function obtenerMenu2($ROLE)
    {
        $menu = [
            // [
            //     'titulo' => 'Material de apoyo',
            //     'icono' => 'ki-duotone ki-book-open',
            //     'url' => '/material'
            // ],
            [
                'titulo' => 'Entrenador',
                'icono' => 'ki-duotone ki-note-2',
                'url' => '/entrenador'
            ],
            [
                'titulo' => 'Prueba Diagnóstica',
                'icono' => 'ki-duotone ki-book',
                'url' => '/simulacros'
            ],
            [
                'titulo' => 'Resultados',
                'icono' => 'ki-duotone ki-graph',
                'url' => '/resultados-simulacros'
            ],
        ];

        return $menu;
    }
}
