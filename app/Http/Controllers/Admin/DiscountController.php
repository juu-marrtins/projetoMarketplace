<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Discount\StoreDiscountRequest;
use App\Http\Requests\Discount\UpdateDiscountRequest;
use App\Http\Services\Admin\DiscountService;
use App\Models\Discount;

class DiscountController extends Controller
{

    public function __construct(protected DiscountService $discountService)
    {}

    public function index()
    {
        return response()->json([
            'discounts' => $this->discountService->getAllDiscounts()
        ], 200);
    }

    public function store(StoreDiscountRequest $request)
    {
        return response()->json([
            'message' => 'Disconto criado com sucesso!',
            'discount' => $this->discountService->createDiscount($request->validated())
        ], 201);
    }

    public function show(string $discountId)
    {
        return response()->json([
            'Discount' => $this->discountService->findDiscountById($discountId)
        ], 200);
    }
    public function update(UpdateDiscountRequest $request, string $discountId)
    {
        $this->discountService->UpdateDiscount($request->validated(), $discountId);

        return response()->json([
            'message' => 'Cupom atualizado com sucesso!'
        ], 200);
    }

    public function destroy(string $discountId)
    {
        $this->discountService->deleteDiscount($discountId);
        
        return response()->json([
            'message' => 'Disconto excluido com sucesso!'
        ], 200);
    }
}

