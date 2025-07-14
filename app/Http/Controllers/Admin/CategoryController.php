<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Services\Admin\CategoryService;

class CategoryController extends Controller
{

    public function __construct(protected CategoryService $categoryService)
    {}

    public function index()
    {
        return response()->json([
            'Categories' => $this->categoryService->getAllCategories()
        ], 200);
    }

    public function store(StoreCategoryRequest $request)
    {
        return response()->json([
            'message' => 'Categoria criada com sucesso!',
            'category' => $this->categoryService->createCategory($request->validated())
        ], 201);
    }

    public function show(string $categoryId)
    {
        return response()->json([
            'category' => $this->categoryService->findCategoryById($categoryId)
        ], 200);
    }

    public function update(UpdateCategoryRequest $request, string $categoryId)
    {   
        $this->categoryService->UpdateCategory($request->validated(), $categoryId);

        return response()->json([
            'message' => 'Categoria atualizada com sucesso!'
        ], 200);
    }

    public function destroy(string $categoryId)
    {
        $this->categoryService->deleteCategory($categoryId);

        return response()->json([
            'message' => ' Categoria excluida com sucesso!'
        ], 200);
    }
}
