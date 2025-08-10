<?php
namespace App\Http\Repository\Admin;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Collection;

class CouponRepository{
    public function all() : Collection
    {
        return Coupon::all();
    }

    public function findById(string $id) : Coupon
    {
        return Coupon::findOrFail($id);
    }

    public function create(array $dataValidated) : Coupon
    {
        return Coupon::create($dataValidated);
    }
}