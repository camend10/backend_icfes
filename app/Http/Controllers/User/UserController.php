<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

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
                'user' => $user
            ], 201);
        } else {
            return response()->json([
                'errors' => "El usuario no fue creado"
            ], 500);
        }
    }

    public function index()
    {
        $users = User::all();

        return response()->json([
            'users' => $users
        ], 200);
    }
}
