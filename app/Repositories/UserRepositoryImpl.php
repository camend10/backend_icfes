<?php

namespace App\Repositories;

use App\Interfaces\UserRepository;
use App\Models\User;

class UserRepositoryImpl implements UserRepository
{
    public function getUserAll()
    {
        return User::all();
    }

    public function getUserById($id)
    {
        // return User::findOrFail($id);

        return User::where('id', $id)
            ->with(
                'tipodocumento',
                'departamento',
                'municipio',
                'curso',
                'grado',
                'rol'
            )
            ->first();
    }

    public function createUser(array $user)
    {
        return User::create($user);
    }

    public function updateUser($id, array $user)
    {
        return User::whereId($id)->update($user);
    }

    public function estadoUser($id, string $valor)
    {
        return User::where(['id' => $id])->update([
            'estado' => $valor
        ]);
    }

    public function resetearUser($id, string $password)
    {
        return User::where(['id' => $id])->update([
            'password' => bcrypt($password)
        ]);
    }

    public function getUserByEmail($email)
    {
        return User::where('email', $email)
            ->with(
                'tipodocumento',
                'departamento',
                'municipio',
                'curso',
                'grado',
                'rol'
            )
            ->first();
    }

    public function updateImgById($id, string $filename)
    {
        return User::where(['id' => $id])->update([
            'foto' => $filename
        ]);
    }

    public function getUsers($txtbusqueda)
    {
        return User::when($txtbusqueda, function ($sql) use ($txtbusqueda) {
            $sql->where('name', 'LIKE', '%' . $txtbusqueda . '%')
                ->orWhere('identificacion', 'LIKE', '%' . $txtbusqueda . '%')
                ->orWhere('email', 'LIKE', '%' . $txtbusqueda . '%');
        })
            ->with(
                'tipodocumento',
                'departamento',
                'municipio',
                'curso',
                'grado',
                'rol'
            )
            ->get();
    }

    public function modifyUser(array $user, $id)
    {
        return User::whereId($id)->update($user);
    }

    public function getUserByUsername($username)
    {
        return User::where('username', $username)
            ->with(
                'tipodocumento',
                'departamento',
                'municipio',
                'curso',
                'grado',
                'rol'
            )
            ->first();
    }

    public function getUserByRol($rol)
    {
        return User::where('role_id', $rol)
            ->where('estado', 1)
            ->get();
    }
}
