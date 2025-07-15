<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Coupon\StoreCouponRequest;
use App\Http\Requests\Admin\Coupon\UpdateCouponRequest;
use App\Http\Services\Admin\CouponService;

class CouponController extends Controller
{

    public function __construct(protected CouponService $couponService)
    {}

    public function index()
    {
        return response()->json([
            'coupons' => $this->couponService->getAllCoupons()
        ], 200);
    }

    public function store(StoreCouponRequest $request)
    {
        return response()->json([
            'message' => 'Cupom criado com sucesso!',
            'Cupom' => $this->couponService->createCoupon($request->validated())
        ], 201);
    }

    public function show(string $couponId)
    {
        return response()->json([
            'Cupom' => $this->couponService->findCouponById($couponId)
        ], 200);
    }

    public function update(UpdateCouponRequest $request, string $couponId)
    {
        $this->couponService->updateCoupon($request->validated(), $couponId);

        return response()->json([
            'message' => 'Cupom atualizado com sucesso!'
        ], 200);
    }

    public function destroy(string $couponId)
    {
        $this->couponService->deleteCoupon($couponId);

        return response()->json([
            'message' => 'Cupom excluido com sucesso!'
        ], 200);
    }
}
