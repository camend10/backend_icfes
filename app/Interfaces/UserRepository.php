<?php

namespace App\Interfaces;

interface UserRepository
{
    public function getUserAll();

    public function getUserById($id);

    public function createUser(array $user);

    public function updateUser($id, array $user);

    public function deleteUser($id, string $valor);

    public function getUserByEmail($email);
}
