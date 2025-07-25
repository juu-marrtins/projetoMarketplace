<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Http\Services\Admin\CategoryService;

class CategoryController extends Controller
{

    public function __construct(protected CategoryService $categoryService)
    {}

    public function index()
    {
        $categories = $this->categoryService->getAllCategories();

        if($categories->isEmpty())
        {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum categoria encontrada.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $categories
        ], 200);
    }

    public function store(StoreCategoryRequest $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Categoria criada com sucesso!',
            'category' => $this->categoryService->createCategory($request->validated())
        ], 201);
    }

    public function show(string $categoryId)
    {
        $category = $this->categoryService->findCategoryById($categoryId);

        if(!$category)
        {
            return response()->json([
                'success' => false,
                'message' => 'Nenhuma categoria encontrada.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $category
        ], 200);
    }

    public function update(UpdateCategoryRequest $request, string $categoryId)
    {   
        $category = $this->categoryService->UpdateCategory($request->validated(), $categoryId);

        if(!$category)
        {
            return response()->json([
                'success' => false,
                'message' => 'Nenhuma categoria encontrada.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Categoria atualizada com sucesso!',
            'data' => $category
        ], 200);
    }

    public function destroy(string $categoryId)
    {
        $category = $this->categoryService->deleteCategory($categoryId);
        if(!$category)
        {
            return response()->json([
                'success' => false,
                'message' => 'Categoria nao pode ser excluida porque existem produtos associado a ela ou é inexistente.'
            ], 400);
        }
        return response()->json([
            'success' => true,
            'message' => ' Categoria excluida com sucesso!'
        ], 200);
    }
}
