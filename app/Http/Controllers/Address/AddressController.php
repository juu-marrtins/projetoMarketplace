<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Http\Services\Address\AddressService;
use App\Models\Address;

class AddressController extends Controller
{

    public function __construct(protected AddressService $addressService)
    {}

    public function addressUser() //    OK
    {
        $addresses = $this->addressService->getAllAddressesUser();

        if(!$addresses)
        {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum endereco encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $addresses
        ], 200);
    }

    public function store(StoreAddressRequest $request) //  OK
    {   
        return response()->json([
            'success' => true,
            'message' => 'Endereco criado com sucesso!',
            'data' => $this->addressService->createAddress($request->validated())
            ], 201);
    }

    public function show(string $addressId){ // OK

        $address = $this->addressService->getAddressById($addressId);

        return response()->json([
            'success' => true,
            'data' => $address
        ], 200);
    }

    public function update(UpdateAddressRequest $request, string $addressId) // OK
    {
        $updatedAddress = $this->addressService->updateAddress($request->validated(), $addressId);

        return response()->json([
            'success' => true,
            'message' => 'Endereco atualizado com sucesso!',
            'data' => $updatedAddress
        ], 200);
    }

    public function destroy(string $addressId) // OK
    {
        $deleted = $this->addressService->deleteAddress($addressId);
        
        return response()->json([
            'success' => true,
            'message' => 'Endereco excluido com sucesso'
        ], 200);
    }
}
