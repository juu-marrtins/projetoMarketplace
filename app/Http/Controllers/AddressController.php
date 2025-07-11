<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->addresses;

        return response()->json([
            'addresses' => $addresses
        ], 200);
    }

    public function store(StoreAddressRequest $request)
    {  
        $dataValidated = $request->validated(); 
        $dataValidated['userId'] = Auth::id();

        $address = Address::create($dataValidated);

        return response()->json([
            'message' => 'Endereco cadastrado com sucesso!',
            'address' => $address
            ], 201);
    }

    public function show(string $addressId){
        $address = Address::findOrFail($addressId);

        return response()->json($address, 200);
    }

    public function update(UpdateAddressRequest $request, string $addressId)
    {
        $address = Auth::user()
                ->addresses()
                ->where('id', $addressId)
                ->firstOrFail();

        $address->update($request->validated());

        return response()->json([
            'message' => 'Endereco atualizado com sucesso!',
            'Address' => $address
        ], 200);
    }

    public function destroy(string $addressId)
    {
        $address = Auth::user()
                ->addresses()
                ->where('id', $addressId)
                ->firstOrFail();
        $address->delete();

        return response()->json([
            'message' => 'Endereco excluido com sucesso!'
        ], 200);
    }
}
