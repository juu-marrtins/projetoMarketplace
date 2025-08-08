<?php

namespace App\Http\Repository\Address;

use App\Models\Address;
use App\Models\User;

class AddressRepository
{

    public function findAddress(User $user, string $id) : Address
    {
        return $user->addresses()->findOrFail($id);
    }

    public function create(array $dataValidated) : Address
    {
        return Address::create($dataValidated);
    }
}   