<?php

namespace App\Http\Services\Admin;

use App\Enums\Admin\CouponDeleteStatus;
use App\Http\Repository\Admin\CouponRepository;
use App\Models\Coupon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CouponService{
    
    public function __construct(protected CouponRepository $couponRepository)
    {}

    public function getAllCoupons() : Collection
    {
        return $this->couponRepository->all();
    }

    public function findCouponById(string $id) : ?Coupon
    {
        try {
            return $this->couponRepository->findById($id); 
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    public function createCoupon(array $dataValidated) : Coupon
    {
        return $this->couponRepository->create($dataValidated);
    }

    public function updateCoupon(array $dataValidated, string $id) : ?Coupon
    {
        $coupon = $this->findCouponById($id);

        if(!$coupon)
        {
            return null;
        }

        $coupon->update($dataValidated);

        return $coupon;
    }

    public function deleteCoupon(string $id) : CouponDeleteStatus
    {
        $coupon = $this->findCouponById($id);

        if(!$coupon) 
        {
            return CouponDeleteStatus::NOT_FOUND;
        }
        if($coupon->orders()->count() > 0)
        {
            return CouponDeleteStatus::HAS_ORDERS;
        }

        $coupon->delete();

        return CouponDeleteStatus::DELETED;
    }
}