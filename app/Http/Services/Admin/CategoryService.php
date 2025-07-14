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
        return $this->categoryRepository->findById($id);
    }

    public function createCategory(array $dataValidated)
    {
        return $this->categoryRepository->create($dataValidated);
    }

    public function UpdateCategory(array $dataValidated, string $id)
    {
        $category = $this->categoryRepository->findById($id);
        return $category->update($dataValidated);
    }

    public function deleteCategory(string $id)
    {
        $category = $this->categoryRepository->findById($id);
        return $category->delete();
    }

}