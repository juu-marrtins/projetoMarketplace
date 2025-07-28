<?php 

namespace App\Http\Services\Moderator;

use App\Http\Repository\Moderator\ProductRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductService
{
    public function __construct(protected ProductRepository $productRepository)
    {}

    public function getAllProducts()
    {
        return $this->productRepository->All();
    }

    public function findProductById(string $id)
    {
        try {
            return $this->productRepository->findById($id); 
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function createProduct(array $dataValidated)
    {
        return $this->productRepository->create($dataValidated);
    }

    public function updateProduct(array $dataValidated, string $id)
    {
        $product = $this->findProductById($id);
            
        if(!$product)
        {
            return null;
        }

        $product->update($dataValidated);

        return $product;
    }

    public function deleteProduct(string $id)
    {
        $product = $this->findProductById($id);

        if(!$product)
        {
            return null;
        }
        
        $product->cartItems()->delete();
        $product->delete();

        return $product;
    }
}