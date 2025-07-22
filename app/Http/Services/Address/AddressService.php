<?php

namespace App\Http\Services\Address;

use App\Http\Repository\Address\AddressRepository;
use Illuminate\Support\Facades\Auth;

class AddressService
{
    public function __construct(protected AddressRepository $addressRepository)
    {}

    public function getAllAddressesUser()
    {
        $address = $this->addressRepository->authAddresses()->get();
        if($address->isEmpty())
        {
            return null;
        }
        return $address;
    }

    public function getAddressById(string $id)
    {
        return $this->addressRepository->findAddress($id);
    }

    public function createAddress(array $dataValidated)
    {
        $dataValidated['userId'] = Auth::id();
        return $this->addressRepository->create($dataValidated);
    }

    public function updateAddress(array $dataValidated, string $addressId)
    {
        $address = $this->addressRepository->findAddress($addressId);

        $address->update($dataValidated); 

        return $address;
    }

    public function deleteAddress(string $addressId)
    {
        $address = $this->addressRepository->findAddress($addressId);

        return $address->delete();
    }
}