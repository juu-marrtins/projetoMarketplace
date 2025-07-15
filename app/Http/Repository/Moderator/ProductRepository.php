<?php

namespace App\Http\Repository\Moderator;

use App\Models\Product;

class ProductRepository
{
    public function All()
    {
        return Product::all();
    }

    public function findById(string $id)
    {
        return Product::findOrFail($id);
    }

    public function create(array $dataValidated)
    {
        return Product::create($dataValidated);
    }
}