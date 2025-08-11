<?php 

namespace App\Http\Services\Moderator;

use App\Enums\Moderator\ProductDeleteStatus;
use App\Http\Repository\Moderator\ProductRepository;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductService
{
    public function __construct(protected ProductRepository $productRepository)
    {}

    public function getAllProducts() : Collection
    {
        return $this->productRepository->all();
    }

    public function findProductById(string $id) : ?Product
    {
        try {
            return $this->productRepository->findById($id); 
        } catch (ModelNotFoundException) {
            return null;
        }
    }   

    public function createProduct(array $dataValidated) : Product
    {
        return $this->productRepository->create($dataValidated);
    }

    public function uploadImage(Request $request) : ?string
    {
        if($request->hasFile('image'))
        {
            return $request->file('image')->store('products', 'public');
        }

        return null;
    }

    public function updateProduct(array $dataValidated, string $id) : ?Product
    {
        $product = $this->findProductById($id);
            
        if(!$product)
        {
            return null;
        }

        $product->update($dataValidated);

        return $product;
    }

    public function deleteProduct(string $id) : ProductDeleteStatus
    {
        $product = $this->findProductById($id);

        if(!$product)
        {
            return ProductDeleteStatus::NOT_FOUND;
        }   
        if ($product->orderItems()->exists())
        {
            return ProductDeleteStatus::HAS_ORDERS_ITEMS;
        }

        $product->cartItems()->delete();
        $product->delete();

        return ProductDeleteStatus::DELETED;
    }
}