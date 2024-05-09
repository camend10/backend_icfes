<?php

namespace App\Interfaces;

interface UserRepository
{
    public function getUserAll();

    public function getUserById($id);

    public function createUser(array $user);

    public function updateUser($id, array $user);

    public function estadoUser($id, string $valor);

    public function resetearUser($id, string $password);

    public function getUserByEmail($email);
    
    public function updateImgById($id, string $filename);
    
    public function getUsers($txtbusqueda);
    
    public function modifyUser(array $user, $id);

    public function getUserByUsername($username);

    public function getUserByRol($rol);
}
