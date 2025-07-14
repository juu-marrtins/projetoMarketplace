<?php

namespace App\Http\Repository\Admin;

use App\Models\User;

class AdminUserRepository
{
    public function create(array $dataValidated)
    {
        return User::create($dataValidated);
    }
}