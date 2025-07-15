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
        return $this->addressRepository->authAddresses()->get();
    }

    public function getAddressById(string $id)
    {
        $address = $this->addressRepository->findAddress($id);
        if(!$address){
            return 'Endereco invalido.';
        }
        return $address;
    }

    public function createAddress(array $dataValidated)
    {
        $dataValidated['userId'] = Auth::id();
        return $this->addressRepository->create($dataValidated);
    }

    public function updateAddress(array $dataValidated, string $addressId)
    {
        $address = $this->addressRepository->findAddress($addressId);
        if(!$address){
            return 'Endereco invalido.';
        }

        return $address->update($dataValidated);
    }

    public function deleteAddress(string $addressId)
    {
        $address = $this->addressRepository->findAddress($addressId);

        if(!$address){
            return 'Endereco invalido.';
        }
        $address->delete();
        return 'Endereco excluido com sucesso!';
    }
}