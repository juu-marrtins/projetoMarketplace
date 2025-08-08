<?php

namespace App\Http\Repository\Moderator;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function all() : Collection
    {
        return Product::all();
    }

    public function findById(string $id) : Product
    {
        return Product::findOrFail($id);
    }

    public function create(array $dataValidated) : Product
    {
        return Product::create($dataValidated);
    }
}