<?php

namespace App\Http\Repository\Address;

use App\Models\Address;
use App\Models\User;

class AddressRepository
{

    public function findAddress(User $user, string $id)
    {
        return $user->addresses()->find($id);
    }

    public function create(array $dataValidated)
    {
        return Address::create($dataValidated);
    }
}   