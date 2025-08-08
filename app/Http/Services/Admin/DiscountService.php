<?php

namespace App\Http\Services\Admin;

use App\Enums\Admin\DiscountDeleteStatus;
use App\Http\Repository\Admin\DiscountRepository;
use App\Models\Discount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DiscountService{
    public function __construct(
        protected DiscountRepository $discountRepository)
    {}

    public function getAllDiscounts() : Collection
    {
        return $this->discountRepository->all();
    }

    public function findDiscountById(string $id) : ?Discount
    {
        try {
            return $this->discountRepository->findById($id); 
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    public function createDiscount(array $dataValidated) : Discount
    {
        return $this->discountRepository->create($dataValidated);
    }

    public function UpdateDiscount(array $dataValidated, string $id) : ?Discount
    {
        $discount  = $this->findDiscountById($id);

        if(!$discount)
        {
            return null;
        }
        $discount->update($dataValidated);
        
        return $discount;
    }

    public function deleteDiscount(string $id) : DiscountDeleteStatus
    {
        $discount = $this->findDiscountById($id);

        if(!$discount)
        {
            return DiscountDeleteStatus::NOT_FOUND;
        }

        $discount->delete();

        return DiscountDeleteStatus::DELETED;
    }
}