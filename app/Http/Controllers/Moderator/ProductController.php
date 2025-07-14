<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
class ProductController extends Controller
{

    // TESTAR CRUD DE PRODUTO
    public function index()
    {
        $products =  Product::all();

        return response()->json($products, 200);
    }

    public function store(StoreProductRequest $request)
    {
        $dataValidated = $request->validated();

        $product = Product::create($dataValidated);

        return response()->json([
            'message' => 'Produto cadastrado com sucesso!'
        ], 201);
    }

    public function show(string $productId)
    {
        $product = Product::findOrFail($productId);

        return response()->json($product, 200);
    }

    public function update(UpdateProductRequest $request, string $productId)
    {
        $product = Product::findOrFail($productId);

        $product->update($request->validated());

        return response()->json([
            'message' => 'Produto atualizado com sucesso!'
        ], 200);
    }

    public function destroy(string $productId)
    {
        $product = Product::findOrFail($productId);

        $product->delete();

        return response()->json([
            'message' => 'Produto excluido com sucesso!'
        ], 200);
    }
}
