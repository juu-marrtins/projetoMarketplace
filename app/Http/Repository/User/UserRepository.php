<?php

namespace App\Http\Repository\User;

use App\Models\User;

class UserRepository
{
    public function createUser(array $dataValidated)
    {
        return User::create($dataValidated);
    }
}