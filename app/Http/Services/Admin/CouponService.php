<?php

namespace App\Http\Services\Admin;

use App\Enums\Admin\CouponDeleteStatus;
use App\Http\Repository\Admin\CouponRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CouponService{
    
    public function __construct(protected CouponRepository $couponRepository)
    {}

    public function getAllCoupons()
    {
        return $this->couponRepository->all();
    }

    public function findCouponById(string $id)
    {
        try {
            return $this->couponRepository->findById($id); 
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    public function createCoupon(array $dataValidated)
    {
        return $this->couponRepository->create($dataValidated);
    }

    public function updateCoupon(array $dataValidated, string $id)
    {
        $coupon = $this->findCouponById($id);

        if(!$coupon)
        {
            return null;
        }

        $coupon->update($dataValidated);

        return $coupon;
    }

    public function deleteCoupon(string $id)
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