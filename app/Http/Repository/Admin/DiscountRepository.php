<?php

namespace App\Http\Repository\Admin;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Collection;

class DiscountRepository{
    
    public function All() : Collection
    {
        return Discount::all();
    }

    public function findById(string $id) : Discount
    {
        return Discount::findOrFail($id);
    }

    public function create(array $dataValidated) : Discount
    {
        return Discount::create($dataValidated);
    }
}