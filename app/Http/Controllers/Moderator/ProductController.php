<?php

namespace App\Http\Controllers\Moderator;

use App\Enums\Moderator\ProductDeleteStatus;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Moderator\StoreProductRequest;
use App\Http\Requests\Moderator\UpdateProductRequest;
use App\Http\Resources\Moderator\ProductResource;
use App\Http\Services\Moderator\ProductService;

class ProductController extends Controller
{

    public function __construct(protected ProductService $productService)
    {}

    public function index()
    {
        $products = $this->productService->getAllProducts();

        if($products->isEmpty())
        {
            return ApiResponse::fail('Nenhum produto encontrado.', 404);
        }

        return ApiResponse::success(
            'Listagem de produtos',
            ProductResource::collection($products),
            200);
    }

    public function store(StoreProductRequest $request)
    {
        $dataValidated = $request->validated();
        $imagePath = $this->productService->uploadImage($request); 

        if ($imagePath) {
            $dataValidated['image'] = $imagePath;
        }

        return ApiResponse::success(
            'Produto cadastrado com sucesso.',
            new ProductResource($this->productService->createProduct($dataValidated)),
            201
        );
    }

    public function show(string $productId)
    {
        $product = $this->productService->findProductById($productId);

        if(!$product)
        {
            return ApiResponse::fail('Produto não encontrado', 404);
        }

        return ApiResponse::success(
            'Produto encontrado.',
            new ProductResource($product),
            200
        );
    }

    public function update(UpdateProductRequest $request, string $productId) 
    {
        $dataValidated = $request->validated();
        $imagePath = $this->productService->uploadImage($request); 

        if ($imagePath) {
            $dataValidated['image'] = $imagePath;
        }

        $product = $this->productService->updateProduct($dataValidated, $productId);

        if(!$product)
        {
            return ApiResponse::fail('Produto não encontrado.', 404);
        }

        return ApiResponse::success(
            'Produto atualizado com sucesso.',
            new ProductResource($product),
            200
        );
    }

    public function destroy(string $productId)
    {
        $product = $this->productService->deleteProduct($productId);

        if($product === ProductDeleteStatus::NOT_FOUND)
        {
            return ApiResponse::fail('Produto não encontrado.', 404);
        }
        
        if ($product === ProductDeleteStatus::HAS_ORDERS_ITEMS)
        {
            return ApiResponse::fail('O produto está em um pedido.', 409);
        }

        return response()->noContent();
    }
}
