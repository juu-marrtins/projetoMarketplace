<?php

namespace App\Http\Services\Admin;

use App\Http\Repository\Admin\CategoryRepository;

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
        return $this->categoryRepository->findOrFailById($id);
    }

    public function createCategory(array $dataValidated)
    {
        return $this->categoryRepository->create($dataValidated);
    }

    public function UpdateCategory(array $dataValidated, string $id)
    {
        $category = $this->categoryRepository->findOrFailById($id);

        $category->update($dataValidated);

        return $category;
    }

    public function deleteCategory(string $id)
    {
        $category = $this->categoryRepository->findOrFailById($id);

        if ($category->products()->count() > 0) 
        {
            return null;
        }
        return $category->delete(); 
    }

}