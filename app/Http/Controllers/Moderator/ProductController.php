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

    public function index() // ok 2.0
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

    public function store(StoreProductRequest $request) // ok .20
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

    public function show(string $productId) // ok 2.0
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

    public function update(UpdateProductRequest $request, string $productId) // ok 2.0
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

    public function destroy(string $productId) // ok 2.0
    {
        $status = $this->productService->deleteProduct($productId);

        match($status)
        {
            ProductDeleteStatus::NOT_FOUND        => ApiResponse::fail('Produto não encontrado.', 404),
            ProductDeleteStatus::HAS_ORDERS_ITEMS => ApiResponse::fail('O produto está em um pedido.', 409),
            ProductDeleteStatus::DELETED          => response()->noContent(),
            default                               => ApiResponse::fail('Erro ao deletar produto.', 500)
        };
    }
}
