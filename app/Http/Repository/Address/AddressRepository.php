<?php

namespace App\Http\Repository\Address;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressRepository
{
    public function authAddresses()
    {
        return Auth::user()->addresses();
    }

    public function findAddress(string $id)
    {
        return $this->authAddresses()->find($id);
    }

    public function create(array $dataValidated)
    {
        return Address::create($dataValidated);
    }
}