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

    public function index() // ok 2.0
    {
        $categories = $this->categoryService->getAllCategories();

        if($categories->isEmpty())
        {
            return ApiResponse::fail('Nenhuma categoria encontrada.', 404);
        }

        return ApiResponse::success(
            'Listagem de categorias.',
            CategoryResource::collection($categories),
            200);
    }

    public function store(StoreCategoryRequest $request) // ok 2.0
    {
        return ApiResponse::success(
            'Categoria criada com sucesso.',
            new CategoryResource($this->categoryService->createCategory($request->validated())),
            201);
    }

    public function show(string $categoryId) // ok 2.0
    {
        $category = $this->categoryService->findCategoryById($categoryId);

        if(!$category)
        {
            return ApiResponse::fail('Categoria não encontrada.', 404);
        }

        return ApiResponse::success(
            'Categria encontrada',
            new CategoryResource($category),
            200);
    }

    public function update(UpdateCategoryRequest $request, string $categoryId) // ok 2.0
    {   
        $category = $this->categoryService->updateCategory($request->validated(), $categoryId);

        if(!$category)
        {
            return ApiResponse::fail('Categoria não encontrada', 404)  ;
        }

        return ApiResponse::success(
            'Categoria atualizada com sucesso.',
            new CategoryResource($category),
            200);
    }

    public function destroy(string $categoryId) // ok 2.0
    {
        $status = $this->categoryService->deleteCategory($categoryId);

        match($status)
        {
            CategoryDeleteStatus::HAS_PRODUCTS => ApiResponse::fail(
                'A categoria não pode ser excluída por existir produtos associados.', 409),
            CategoryDeleteStatus::NOT_FOUND    => ApiResponse::fail('Categoria não encontrada.', 404),
            CategoryDeleteStatus::DELETED      =>  response()->noContent(),
            default                            => ApiResponse::fail('Erro ao deletar categoria.', 500)
        };
    }
}
