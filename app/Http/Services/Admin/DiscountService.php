<?php

namespace App\Http\Services\Admin;

use App\Http\Repository\Admin\DiscountRepository;

class DiscountService{
    public function __construct(protected DiscountRepository $discountRepository)
    {}

    public function getAllDiscounts()
    {
        return $this->discountRepository->all();
    }

    public function findDiscountById(string $id)
    {
        return $this->discountRepository->findById($id);
    }

    public function createDiscount(array $dataValidated)
    {
        return $this->discountRepository->create($dataValidated);
    }

    public function UpdateDiscount(array $dataValidated, string $id)
    {
        $discount  = $this->discountRepository->findById($id);
        return $discount->update($dataValidated);
    }

    public function deleteDiscount(string $id)
    {
        $discount = $this->discountRepository->findById($id);
        return $discount->delete();
    }
}