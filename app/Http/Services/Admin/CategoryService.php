<?php

namespace App\Http\Services\Admin;

use App\Enums\Admin\CategoryDeleteStatus;
use App\Http\Repository\Admin\CategoryRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryService
{
    public function __construct(protected CategoryRepository $categoryRepository)
    {}


    public function getAllCategories()
    {
        return $this->categoryRepository->all();
    }

    public function findCategoryById(string $id)
    {
        try {
            return $this->categoryRepository->findOrFailById($id); 
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    public function createCategory(array $dataValidated)
    {
        return $this->categoryRepository->create($dataValidated);
    }

    public function updateCategory(array $dataValidated, string $id)
    {
        $category = $this->findCategoryById($id);

        if(!$category)
        {
            return null;
        }

        $category->update($dataValidated);

        return $category;
    }

    public function deleteCategory(string $id)
    {
        $category = $this->findCategoryById($id);

        if($category == null)
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