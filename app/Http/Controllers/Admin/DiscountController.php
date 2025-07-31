<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Discount\StoreDiscountRequest;
use App\Http\Requests\Admin\Discount\UpdateDiscountRequest;
use App\Http\Services\Admin\DiscountService;

class DiscountController extends Controller
{

    public function __construct(protected DiscountService $discountService)
    {}

    public function index()
    {
        $discounts = $this->discountService->getAllDiscounts();

        if($discounts->isEmpty())
        {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum desconto encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $discounts
        ], 200);
    }

    public function store(StoreDiscountRequest $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Desconto criado com sucesso!',
            'data' => $this->discountService->createDiscount($request->validated())
        ], 201);
    }

    public function show(string $discountId)
    {
        $discount = $this->discountService->findDiscountById($discountId);

        if(!$discount)
        {
            return response()->json([
                'success' => false,
                'message' => 'Desconto nao encontrado.'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $discount
        ], 200);
    }
    public function update(UpdateDiscountRequest $request, string $discountId)
    {
        $discount = $this->discountService->UpdateDiscount($request->validated(), $discountId);

        if(!$discount)
        {
            return response()->json([
                'success' => false,
                'message' => 'Desconto nao encontrado.'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Desconto atualizado com sucesso!',
            'data' => $discount
        ], 200);
    }

    public function destroy(string $discountId)
    {
        $discount = $this->discountService->deleteDiscount($discountId);

        //arrumar para caso ele nao exista
        if(!$discount)
        {
            return response()->json([
                'success' => false,
                'message' => 'Desconto possue produtos associado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Desconto excluido com sucesso!',
        ], 200);

    }
}

