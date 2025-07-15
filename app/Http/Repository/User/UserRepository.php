<?php

namespace App\Http\Repository\User;

use App\Models\User;

class UserRepository
{

    public function All()
    {
        return User::all();
    }

    public function findById(string $id)
    {
        return User::finOrFail($id);
    }

    public function createUser(array $dataValidated)
    {
        return User::create($dataValidated);
    }
}