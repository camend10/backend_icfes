<?php

namespace App\Services;

use App\Interfaces\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(array $request)
    {
        $request['password'] = bcrypt($request['password']);
        $request['estado'] = 1;
        if ($request['rol_id'] == 1 || $request['rol_id'] == 2) {
            $request['tipo'] = "tipo_admin";
        } else {
            $request['tipo'] = "tipo_simulador";
        }

        return $this->userRepository->createUser($request);
    }

    public function updateUser(array $request, $id): int
    {
        return $this->userRepository->updateUser($id, $request);
    }

    public function deleteUser(int $id, string $valor): int
    {
        return $this->userRepository->deleteUser($id, $valor);
    }

    public function getUserByEmail($email)
    {
        return $this->userRepository->getUserByEmail($email);
    }
}
