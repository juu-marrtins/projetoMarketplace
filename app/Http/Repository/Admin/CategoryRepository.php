<?php

namespace App\Http\Repository\Admin;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    public function all() : Collection
    {
        return Category::all();
    }

    public function findOrFailById(string $id) : Category
    {
        return Category::findOrFail($id);
    }

    public function create(array $dataValidated) : Category
    {
        return Category::create($dataValidated);
    }
}