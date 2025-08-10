<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Admin\CouponDeleteStatus;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Coupon\StoreCouponRequest;
use App\Http\Requests\Admin\Coupon\UpdateCouponRequest;
use App\Http\Resources\Admin\CouponResource;
use App\Http\Services\Admin\CouponService;

class CouponController extends Controller
{

    public function __construct(protected CouponService $couponService)
    {}

    public function index() // ok 2.0
    {
        $coupons = $this->couponService->getAllCoupons();
        
        if($coupons->isEmpty())
        {
            return ApiResponse::fail('Nenhum cupom encontrado.', 404);
        }
        return ApiResponse::success(
            'Listagem de cupons',
            CouponResource::collection($coupons),
            200);
    }

    public function store(StoreCouponRequest $request) // ok 2.0
    {
        return ApiResponse::success(
            'Cupom criado com sucesso.',
            new CouponResource($this->couponService->createCoupon($request->validated())),
            201);
    }

    public function show(string $couponId) // ok 2.0
    {

        $coupon = $this->couponService->findCouponById($couponId);

        if(!$coupon)
        {
            return ApiResponse::fail('Cupom não encontrado', 404);  
        }

        return ApiResponse::success(
            'Cupom encontrado',
            new CouponResource($coupon),
            200);
    }

    public function update(UpdateCouponRequest $request, string $couponId) // ok 2.0
    {
        $coupon = $this->couponService->updateCoupon($request->validated(), $couponId);
        
        if(!$coupon)
        {
            return ApiResponse::fail('Cupom não encontrado', 404);
        }

        return ApiResponse::success(
            'Cupom atualizado com sucesso.',
            new CouponResource($coupon),
            200);
    }

    public function destroy(string $couponId) // ok 2.0
    {
        $status = $this->couponService->deleteCoupon($couponId);

        match($status)
        {
            CouponDeleteStatus::HAS_ORDERS => ApiResponse::fail('O cupom possue pedidos associado a ele.', 409),
            CouponDeleteStatus::NOT_FOUND  => ApiResponse::fail('Cupom não encontrado.', 404),
            CouponDeleteStatus::DELETED    => response()->noContent(),
            default                        => ApiResponse::fail('Erro ao deletar cupom.', 500)
        };
    }
}
