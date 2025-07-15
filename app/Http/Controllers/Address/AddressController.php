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

    public function addressUser()
    {
        return response()->json([
            'addresses' => $this->addressService->getAllAddressesUser()
        ], 200);
    }

    public function store(StoreAddressRequest $request)
    {  
        return response()->json([
            'message' => 'Endereco cadastrado com sucesso!',
            'address' => $this->addressService->createAddress($request->validated())
            ], 201);
    }

    public function show(string $addressId){
        return response()->json([
            'Address' => $this->addressService->getAddressById($addressId)
        ]);
    }

    public function update(UpdateAddressRequest $request, string $addressId)
    {
        return response()->json([
            'message' => 'Endereco atualizado com sucesso!'
        ], 200);
    }

    public function destroy(string $addressId)
    {
        return response()->json([
            'message' => $this->addressService->deleteAddress($addressId)
        ], 200);
    }
}
