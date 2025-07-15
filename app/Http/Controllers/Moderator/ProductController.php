<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moderator\StoreProductRequest;
use App\Http\Requests\Moderator\UpdateProductRequest;
use App\Http\Services\Moderator\ProductService;
use App\Models\Product;
class ProductController extends Controller
{

    public function __construct(protected ProductService $productService)
    {}

    public function index()
    {
        return response()->json([
            'products' => $this->productService->getAllProducts()
        ], 200);
    }

    public function store(StoreProductRequest $request)
    {
        $this->productService->createProduct($request->validated());

        return response()->json([
            'message' => 'Produto cadastrado com sucesso!'
        ], 201);
    }

    public function show(string $productId)
    {
        return response()->json([
            'product' => $this->productService->getProductById($productId)
        ], 200);
    }

    public function update(UpdateProductRequest $request, string $productId)
    {
        $this->productService->updateProduct($request->validated(), $productId);

        return response()->json([
            'message' => 'Produto atualizado com sucesso!'
        ], 200);
    }

    public function destroy(string $productId)
    {
        $this->productService->deleteProduct($productId);
        
        return response()->json([
            'message' => 'Produto excluido com sucesso!'
        ], 200);
    }
}
