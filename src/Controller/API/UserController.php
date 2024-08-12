<?php

namespace Controller\API;

use Model\User;

class UserController
{
    public function index()
    {
        $users = User::all();

        $users = json_encode(['data' => $users], JSON_THROW_ON_ERROR);

        return $users;
    }
}