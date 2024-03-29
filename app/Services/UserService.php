<?php

namespace App\Services;

use App\Interfaces\UserRepository;
use DateTime;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(array $request)
    {
        $request['password'] = bcrypt($request['identificacion']);
        $request['estado'] = 1;
        $request['fecha_nacimiento'] = new DateTime($request['fecha_nacimiento']);
        $request['fecha_nacimiento'] = $request['fecha_nacimiento']->format('Y-m-d');
        switch ($request["role_id"]) {
            case 1:
                $request['tipo'] = "tipo_admin";
                break;
            case 2:
                $request['tipo'] = "tipo_usuario";
                break;
            case 3:
                $request['tipo'] = "tipo_estudiante";
                break;
            case 4:
                $request['tipo'] = "tipo_docente";
                break;
        }

        $request['user_id'] = auth()->user()->id;
        return $this->userRepository->createUser($request);
    }

    public function modifyUser(array $request, $id)
    {

        $request['fecha_nacimiento'] = new DateTime($request['fecha_nacimiento']);
        $request['fecha_nacimiento'] = $request['fecha_nacimiento']->format('Y-m-d');

        switch ($request["role_id"]) {
            case 1:
                $request['tipo'] = "tipo_admin";
                break;
            case 2:
                $request['tipo'] = "tipo_usuario";
                break;
            case 3:
                $request['tipo'] = "tipo_estudiante";
                break;
            case 4:
                $request['tipo'] = "tipo_docente";
                break;
        }

        $request['user_id'] = auth()->user()->id;
        return $this->userRepository->modifyUser($request, $id);
    }

    public function updateUser(array $request, $id): int
    {
        return $this->userRepository->updateUser($id, $request);
    }

    public function estadoUser(int $id, string $valor): int
    {
        return $this->userRepository->estadoUser($id, $valor);
    }

    public function resetearUser(int $id, string $password): int
    {
        return $this->userRepository->resetearUser($id, $password);
    }

    public function getUserByEmail($email)
    {
        return $this->userRepository->getUserByEmail($email);
    }

    public function getUserById($id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function updateImgById($id, string $filename)
    {
        return $this->userRepository->updateImgById($id, $filename);
    }

    public function getUsers($txtbusqueda)
    {
        return $this->userRepository->getUsers($txtbusqueda);
    }
}
