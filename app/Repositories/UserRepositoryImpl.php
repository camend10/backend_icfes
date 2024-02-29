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
        return User::findOrFail($id);
    }

    public function createUser(array $user)
    {
        return User::create($user);
    }

    public function updateUser($id, array $user)
    {
        return User::whereId($id)->update($user);
    }

    public function deleteUser($id, string $valor)
    {
        return User::where(['id' => $id])->update([
            'estado' => $valor
        ]);;
    }

    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }
}
