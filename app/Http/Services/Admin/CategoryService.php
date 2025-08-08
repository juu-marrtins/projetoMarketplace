<?php

namespace App\Http\Services\Admin;

use App\Enums\Admin\CategoryDeleteStatus;
use App\Http\Repository\Admin\CategoryRepository;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryService
{
    public function __construct(protected CategoryRepository $categoryRepository)
    {}


    public function getAllCategories() : Collection
    {
        return $this->categoryRepository->all();
    }

    public function findCategoryById(string $id) : ?Category
    {
        try {
            return $this->categoryRepository->findOrFailById($id); 
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    public function createCategory(array $dataValidated) : Category
    {
        return $this->categoryRepository->create($dataValidated);
    }

    public function updateCategory(array $dataValidated, string $id) : ?Category
    {
        $category = $this->findCategoryById($id);

        if(!$category)
        {
            return null;
        }

        $category->update($dataValidated);

        return $category;
    }

    public function deleteCategory(string $id) : CategoryDeleteStatus
    {
        $category = $this->findCategoryById($id);

        if(!$category)
        {
            return CategoryDeleteStatus::NOT_FOUND;
        }
        if($category->products()->count() > 0)
        {
            return CategoryDeleteStatus::HAS_PRODUCTS;
        }

        $category->delete();
        
        return CategoryDeleteStatus::DELETED;
    }
}