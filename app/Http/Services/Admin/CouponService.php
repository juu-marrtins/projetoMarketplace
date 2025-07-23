<?php

namespace App\Http\Services\Admin;

use App\Http\Repository\Admin\CouponRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CouponService{
    
    public function __construct(protected CouponRepository $couponRepository)
    {}

    public function getAllCoupons()
    {
        return $this->couponRepository->All();
    }

    public function findCouponById(string $id)
    {
        try {
            return $this->couponRepository->findById($id); 
        } catch (ModelNotFoundException $e) {
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

        if(!$coupon || $coupon->orders()->count() > 0) 
        {
            return null;
        }

        return $coupon->delete();
    }
}