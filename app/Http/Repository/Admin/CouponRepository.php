<?php
namespace App\Http\Repository\Admin;

use App\Models\Coupon;

class CouponRepository{
    public function All()
    {
        return Coupon::all();
    }

    public function findById(string $id)
    {
        return Coupon::findOrFail($id);
    }

    public function create(array $dataValidated)
    {
        return Coupon::create($dataValidated);
    }
}