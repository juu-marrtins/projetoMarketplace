<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Admin\CategoryDeleteStatus;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
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
            return ApiResponse::fail('Nenhuma categoria encontrada.', 404);
        }

        return ApiResponse::success(CategoryResource::collection($categories), 200);
    }

    public function store(StoreCategoryRequest $request)
    {
        return ApiResponse::success(new CategoryResource(
            $this->categoryService->createCategory($request->validated())), 201);
    }

    public function show(string $categoryId)
    {
        $category = $this->categoryService->findCategoryById($categoryId);

        if(!$category)
        {
            return ApiResponse::fail('Categoria não encontrada.', 404);
        }

        return ApiResponse::success(new CategoryResource($category), 200);
    }

    public function update(UpdateCategoryRequest $request, string $categoryId)
    {   
        $category = $this->categoryService->updateCategory($request->validated(), $categoryId);

        if(!$category)
        {
            return ApiResponse::fail('Categoria não encontrada', 404);
        }

        return ApiResponse::success(new CategoryResource($category), 200);
    }

    public function destroy(string $categoryId)
    {
        $category = $this->categoryService->deleteCategory($categoryId);

        if($category === CategoryDeleteStatus::HAS_PRODUCTS)
        {
            return ApiResponse::fail(
                'A categoria não pode ser excluída por existir produtos associados.', 409);
        }
        if($category === CategoryDeleteStatus::NOT_FOUND){
            return ApiResponse::fail('Categoria não encontrada.', 404);
        }
        return response()->noContent();
    }
}
