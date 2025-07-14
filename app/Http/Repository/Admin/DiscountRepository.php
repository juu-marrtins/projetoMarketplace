<?php

namespace App\Http\Repository\Admin;

use App\Models\Discount;

class DiscountRepository{
    
    public function All()
    {
        return Discount::all();
    }

    public function findById(string $id)
    {
        return Discount::findOrFail($id);
    }

    public function create(array $dataValidated)
    {
        return Discount::create($dataValidated);
    }
}