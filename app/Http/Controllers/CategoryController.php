<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();

        return response()->json([
            'Categories' => $category
        ], 200);
    }

    public function store(StoreCategoryRequest $request)
    {
        $dataValidated = $request->validated();

        $category = Category::create($dataValidated);

        return response()->json([
            'message' => 'Categoria criada com sucesso!',
            'category' => $category
        ], 201);
    }

    public function show(string $categoryId)
    {
        $category = Category::findOrFail($categoryId);

        return response()->json([
            'category' => $category
        ], 200);
    }

    public function update(UpdateCategoryRequest $request, string $categoryId)
    {
        $category = Category::findOrFail($categoryId);

        $category->update($request->validated());
        
        return response()->json([
            'message' => 'Categoria atualizada com sucesso!'
        ], 200);
    }

    public function destroy(string $categoryId)
    {
        $category = Category::findOrFail($categoryId);

        $category->delete();

        return response()->json([
            'message' => ' Categoria excluida com sucesso!'
        ], 200);
    }
}
