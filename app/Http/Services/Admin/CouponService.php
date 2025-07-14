<?php

namespace App\Http\Services\Admin;

use App\Http\Repository\Admin\CouponRepository;

class CouponService{
    
    public function __construct(protected CouponRepository $couponRepository)
    {}

    public function getAllCoupons()
    {
        return $this->couponRepository->All();
    }

    public function findCouponById(string $id)
    {
        return $this->couponRepository->findById($id);
    }

    public function createCoupon(array $dataValidated)
    {
        return $this->couponRepository->create($dataValidated);
    }

    public function updateCoupon(array $dataValidated, string $id)
    {
        $coupon = $this->couponRepository->findById($id);
        return $coupon->update($dataValidated);
    }

    public function deleteCoupon(string $id)
    {
        $coupon = $this->couponRepository->findById($id);
        return $coupon->delete();
    }
}