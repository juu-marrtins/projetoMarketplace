<?php

namespace App\Http\Services\Address;

use App\Http\Repository\Address\AddressRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class AddressService
{
    public function __construct(protected AddressRepository $addressRepository)
    {}

    public function getAllAddressesUser()
    {
        return $this->addressRepository->authAddresses()->get();
    }

    public function findAddressById(string $id)
    {
        try {
            return $this->addressRepository->findAddress($id); 
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function createAddress(array $dataValidated)
    {
        $dataValidated['userId'] = Auth::id();
        return $this->addressRepository->create($dataValidated);
    }

    public function updateAddress(array $dataValidated, string $addressId)
    {
        $address = $this->findAddressById($addressId);
        
        if(!$address)
        {
            return null;
        }

        $address->update($dataValidated); 

        return $address;
    }

    public function deleteAddress(string $addressId)
    {
        $address = $this->findAddressById($addressId);

        if(!$address || $address->orders()->count() > 0)
        {
            return null;
        }

        return $address->delete();
    }
}