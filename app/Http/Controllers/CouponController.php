<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Coupon;
use PHPUnit\Framework\Constraint\Count;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupon = Coupon::all();

        return response()->json([
            'coupons' => $coupon
        ], 200);
    }

    public function store(StoreCouponRequest $request)
    {
        $dataValidated = $request->validated();

        $coupon = Coupon::create($dataValidated);

        return response()->json([
            'message' => 'Cupom criado com sucesso!',
            'Cupom' => $coupon
        ], 201);
    }

    public function show(string $couponId)
    {
        $coupon = Coupon::findOrFail($couponId);

        return response()->json([
            'Cupom' => $coupon
        ], 200);
    }

    public function update(UpdateCouponRequest $request, string $couponId)
    {
        $coupon = Coupon::findOrFail($couponId);

        $coupon->update($request->validated());

        return response()->json([
            'message' => 'Cupom atualizado com sucesso!'
        ], 200);
    }

    public function destroy(string $couponId)
    {
        $coupon = Coupon::findOrFail($couponId);

        $coupon->delete();

        return response()->json([
            'message' => 'Cupom excluido com sucesso!'
        ], 200);
    }
}
