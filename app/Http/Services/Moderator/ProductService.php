<?php 

namespace App\Http\Services\Moderator;

use App\Http\Repository\Moderator\ProductRepository;

class ProductService
{
    public function __construct(protected ProductRepository $productRepository)
    {}

    public function getAllProducts()
    {
        return $this->productRepository->All();
    }

    public function getProductById(string $id)
    {
        return $this->productRepository->findById($id);
    }

    public function createProduct(array $dataValidated)
    {
        return $this->productRepository->create($dataValidated);
    }

    public function updateProduct(array $dataValidated, string $id)
    {
        $product = $this->productRepository->findById($id);
        
        return $product->update($dataValidated);
    }

    public function deleteProduct(string $id)
    {
        $product = $this->productRepository->findById($id);

        return $product->delete();
    }
}