<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moderator\StoreProductRequest;
use App\Http\Requests\Moderator\UpdateProductRequest;
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
            return response()->json([
                'success' => false,
                'message' => 'Nenhum produto encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $products
        ], 200);
    }

    public function store(StoreProductRequest $request)
    {
        $dataValidated = $request->validated();

        if($request->hasFile('image'))
        {
            $imagePath = $request->file('image')->store('products', 'public');
            $dataValidated['image'] =  $imagePath;
        }

        return response()->json([
            'success' => true,
            'message' => 'Produto cadastrado com sucesso!',
            'data' =>  $this->productService->createProduct($dataValidated)
        ], 201);
    }

    public function show(string $productId)
    {
        $product = $this->productService->findProductById($productId);

        if(!$product)
        {
            return response()->json([
                'success' => false,
                'message' => 'Produto nao encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ], 200);
    }

    public function update(UpdateProductRequest $request, string $productId) 
    {
        $dataValidated = $request->validated();

        if($request->hasFile('image'))
        {
            $imagePath = $request->file('image')->store('products', 'public');
            $dataValidated['image'] =  $imagePath;
        }

        $product = $this->productService->updateProduct($dataValidated, $productId);

        if(!$product)
        {
            return response()->json([
                'success' => false,
                'message' => 'Produto nao encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produto atualizado com sucesso!',
            'data' => $product
        ], 200);
    }

    public function destroy(string $productId)
    {
        $product = $this->productService->deleteProduct($productId);

        if(!$product)
        {
            return response()->json([
                'success' => false,
                'message' => 'Produto nao encontrado.'
            ], 404);
        }
        if ($product === 'used_in_orders')
        {
            return response()->json([
                'success' => false,
                'message' => 'Produto ja foi vendido e nao pode ser excluido.'
            ], 409);
        }

        
        return response()->json([
            'success' => true,
            'message' => 'Produto excluido com sucesso!'
        ], 200);
    }
}
