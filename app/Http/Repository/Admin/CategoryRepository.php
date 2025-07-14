<?php

namespace App\Http\Repository\Admin;

use App\Models\Category;

class CategoryRepository
{
    public function All()
    {
        return Category::all();
    }

    public function findById(string $id)
    {
        return Category::findOrFail($id);
    }

    public function create(array $dataValidated)
    {
        return Category::create($dataValidated);
    }
}