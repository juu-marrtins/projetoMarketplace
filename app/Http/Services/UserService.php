<?php

namespace App\Http\Services;

use App\Models\User;

class UserService{
    public function createUser(array $dataValidated)
    {
        return User::create($dataValidated);
    }
}