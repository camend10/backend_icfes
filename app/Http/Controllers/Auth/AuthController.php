<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\UserService;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

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
        try {
            if (!$token = JWTAuth::attempt([
                "email" => $request->email,
                "password" => $request->password,
                "estado" => 1,
                "tipo" => "tipo_admin"
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

        $user = $this->userService->getUserByEmail($request->email);

        return $this->respondWithToken($token, $user);
    }

    public function loginSimulador(LoginRequest $request)
    {
        // $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt([
                "email" => $request->email,
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

        $user = $this->userService->getUserByEmail($request->email);

        return $this->respondWithToken($token, $user);
    }

    protected function respondWithToken($token, $user)
    {

        $actual = Carbon::now();
        $edad = $actual->diffInYears($user->fecha_nacimiento, $actual);

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
        ], 200);
    }
}
