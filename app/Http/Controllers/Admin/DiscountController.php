<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Admin\DiscountDeleteStatus;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Discount\StoreDiscountRequest;
use App\Http\Requests\Admin\Discount\UpdateDiscountRequest;
use App\Http\Resources\Admin\DiscountResource;
use App\Http\Services\Admin\DiscountService;

class DiscountController extends Controller
{

    public function __construct(protected DiscountService $discountService)
    {}

    public function index() // ok 2.0
    {
        $discounts = $this->discountService->getAllDiscounts();

        if($discounts->isEmpty())
        {
            return ApiResponse::fail('Nenhum desconto encontrado.', 404);
        }

        return ApiResponse::success(
            'Listagem de descontos.', 
            DiscountResource::collection($discounts),
            200);
    }

    public function store(StoreDiscountRequest $request) // ok 2.0
    {
        return ApiResponse::success(
            'Desconto criado com sucesso.',
            new DiscountResource($this->discountService->createDiscount($request->validated())),
            201);
    }

    public function show(string $discountId) // ok 2.0
    {
        $discount = $this->discountService->findDiscountById($discountId);

        if(!$discount)
        {
            return ApiResponse::fail('Desconto não encontrado.', 404);
        }
        return ApiResponse::success(
            'Desconto encontrado',
            new DiscountResource($discount),
            200);
    }

    public function update(UpdateDiscountRequest $request, string $discountId) // ok 2.0
    {
        $discount = $this->discountService->UpdateDiscount($request->validated(), $discountId);

        if(!$discount)
        {
            return ApiResponse::fail('Desconto não encontrado.', 404);
        }

        return ApiResponse::success(
            'Desconto atualizado com sucesso.',
            new DiscountResource($discount),
            200);
    }

    public function destroy(string $discountId) // ok 2.0
    {
        $status = $this->discountService->deleteDiscount($discountId);

        match($status)
        {
            DiscountDeleteStatus::NOT_FOUND => ApiResponse::fail('Desconto não encontrado.', 404),
            DiscountDeleteStatus::DELETED   => response()->noContent(),
            default                         => ApiResponse::fail('Erro ao deletar desconto.', 500)
        };
    }
}

