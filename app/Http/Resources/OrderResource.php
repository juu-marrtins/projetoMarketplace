<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'addressId' => $this->addressId,
            'orderDate' => $this->orderDate,
            'totalAmount' => $this->totalAmount,
            'couponId' => $this->couponId,
            'status' => $this->status,
            'items' => $this->orderItems->map(function ($item){
                return [
                    'productId' => $item->productId,
                    'name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'image' => $item->product->image,
                    'category' => $item->product->category->name
                ];
            }),
        ];
    } 
}   

