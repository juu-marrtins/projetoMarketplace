<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Models\Discount;

class DiscountController extends Controller
{

    //TESTAR CRUD DE DISCONTO (PRECISA CRIAR PRODUTO PARA TESTES) --------------
    public function index()
    {
        $discount = Discount::all();

        return response()->json([
            'discounts' => $discount
        ], 200);
    }

    public function store(StoreDiscountRequest $request)
    {
        $dataValidated = $request->validated();

        $discount = Discount::create($dataValidated);

        return response()->json([
            'message' => 'Disconto criado com sucesso!',
            'discount' => $discount
        ], 201);
    }

    public function show(string $discountId)
    {
        $discount = Discount::findOrFail($discountId);

        return response()->json([
            'Discount' => $discount
        ], 200);
    }
    public function update(UpdateDiscountRequest $request, string $discountId)
    {
        $discount = Discount::findOrFail($discountId);

        $discount->update($request->validated());

        return response()->json([
            'message' => 'Cupom atualizado com sucesso!'
        ], 200);
    }

    public function destroy(string $discountId)
    {
        $discount = Discount::findOrFail($discountId);

        $discount->delete();

        return response()->json([
            'message' => 'Disconto excluido com sucesso!'
        ], 200);
    }
}

