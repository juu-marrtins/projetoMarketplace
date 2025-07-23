<?php

namespace App\Http\Services\Admin;

use App\Http\Repository\Admin\CategoryRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryService
{
    public function __construct(protected CategoryRepository $categoryRepository)
    {}


    public function getAllCategories()
    {
        return $this->categoryRepository->All();
    }

    public function findCategoryById(string $id)
    {
        try {
            return $this->categoryRepository->findOrFailById($id); 
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function createCategory(array $dataValidated)
    {
        return $this->categoryRepository->create($dataValidated);
    }

    public function UpdateCategory(array $dataValidated, string $id)
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

        if($category == null || $category->products()->count() > 0)
        {
            return null;
        }

        return $category->delete();
    }
}