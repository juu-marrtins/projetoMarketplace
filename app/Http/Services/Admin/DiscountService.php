<?php

namespace App\Http\Services\Admin;

use App\Http\Repository\Admin\DiscountRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DiscountService{
    public function __construct(protected DiscountRepository $discountRepository)
    {}

    public function getAllDiscounts()
    {
        return $this->discountRepository->all();
    }

    public function findDiscountById(string $id)
    {
        try {
            return $this->discountRepository->findById($id); 
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function createDiscount(array $dataValidated)
    {
        return $this->discountRepository->create($dataValidated);
    }

    public function UpdateDiscount(array $dataValidated, string $id)
    {
        $discount  = $this->findDiscountById($id);

        if(!$discount)
        {
            return null;
        }

        return $discount->update($dataValidated);
    }

    public function deleteDiscount(string $id)
    {
        $discount = $this->findDiscountById($id);

        if(!$discount || $discount->product != null)
        {
            return null;
        }

        return $discount->delete();
    }
}