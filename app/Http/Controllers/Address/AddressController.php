<?php

namespace App\Http\Controllers\Address;

use App\Enums\Address\AddressDeleteStatus;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Http\Resources\Address\AddressResource;
use App\Http\Services\Address\AddressService;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function __construct(protected AddressService $addressService)
    {}

    public function addressUser() // SUPER OK
    {
        $addresses = $this->addressService->getAllAddressesUser(Auth::user());

        if($addresses->isEmpty())
        {
            return ApiResponse::fail('Nenhum endereco encontrado', 404);
        }

        return ApiResponse::success(
            AddressResource::collection($addresses), 200);
    }

    public function store(StoreAddressRequest $request) // SUPER OK
    {   
        return ApiResponse::success(
            new AddressResource($this->addressService->createAddress(
                $request->validated(), 
                Auth::id())), 
                201);
    }

    public function show(string $addressId)
    {  // SUPER OK

        $address = $this->addressService->findAddressById(Auth::user(),$addressId);

        if(!$address)
        {
            return ApiResponse::fail('Endereco não encontrado.', 404);
        }

        return ApiResponse::success(new AddressResource($address), 200);
    }

    public function update(UpdateAddressRequest $request, string $addressId) // SUPER OK
    {
        $address = $this->addressService->updateAddress(
            $request->validated(), 
            $addressId, 
            Auth::user());

        if(!$address)
        {
            return ApiResponse::fail('Endereco não encontrado.', 404);
        }

        return ApiResponse::success(new AddressResource($address), 200);
    }

    public function destroy(string $addressId) // SUPER OK
    {
        $address = $this->addressService->deleteAddress($addressId, Auth::user());

        if($address === AddressDeleteStatus::NOT_FOUND)
        {
            return ApiResponse::fail('Endereco não encontrado.', 404);
        }
        if($address === AddressDeleteStatus::HAS_ORDERS)
        {
            return ApiResponse::fail('O endereco possue pedidos associados.', 409);
        }
        
        return response()->noContent();
    }
}
