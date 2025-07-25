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

        $coupons = $this->couponService->getAllCoupons(); // OK
        
        if($coupons->isEmpty())
        {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum cupom encontrado.'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $coupons
        ], 200);
    }

    public function store(StoreCouponRequest $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Coupon criado com sucesso!',
            'Cupom' => $this->couponService->createCoupon($request->validated())
        ], 201);
    }

    public function show(string $couponId)
    {

        $coupon = $this->couponService->findCouponById($couponId);

        if(!$coupon)
        {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum cupom encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $coupon
        ], 200);
    }

    public function update(UpdateCouponRequest $request, string $couponId)
    {
        $coupon = $this->couponService->updateCoupon($request->validated(), $couponId);
        
        if(!$coupon)
        {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum cupom encontrado',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Cupom atualizado com sucesso!',
            'data' => $coupon
        ], 200);
    }

    public function destroy(string $couponId)
    {
        $coupon = $this->couponService->deleteCoupon($couponId);

        if(!$coupon)
        {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum cupom encontrado para exclusao ou a pedidos associado a ele.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cupom excluido com sucesso!'
        ], 200);
    }
}
