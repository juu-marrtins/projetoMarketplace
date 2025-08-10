<?php

namespace App\Http\Services\Address;

use App\Enums\Address\AddressDeleteStatus;
use App\Http\Repository\Address\AddressRepository;
use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddressService
{
    public function __construct(protected AddressRepository $addressRepository)
    {}

    public function getAllAddressesUser(User $user) : Collection
    {
        return $user->addresses()->get();
    }

    public function findAddressById(User $user, string $addressId) : ?Address
    {
        try {
            return $this->addressRepository->findAddress($user, $addressId); 
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    public function createAddress(array $dataValidated, int $userId) : Address
    {
        $dataValidated['userId'] = $userId;
        return $this->addressRepository->create($dataValidated);
    }

    public function updateAddress(array $dataValidated, string $addressId, User $user) : ?Address
    {
        $address = $this->findAddressById($user, $addressId);
        
        if(!$address)
        {
            return null;
        }

        $address->update($dataValidated); 

        return $address;
    }

    public function deleteAddress(string $addressId, User $user) : AddressDeleteStatus
    {
        $address = $this->findAddressById($user, $addressId);

        if(!$address)
        {
            return AddressDeleteStatus::NOT_FOUND;
        }

        if($address->orders()->count() > 0)
        {
            return AddressDeleteStatus::HAS_ORDERS;
        }

        $address->delete();
        return AddressDeleteStatus::DELETED;
    }
}