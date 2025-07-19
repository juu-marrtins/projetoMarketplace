<?php

namespace App\Http\Repository;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderRepository
{
    public function all()
    {
        return Order::all();
    }

    public function findByUser()
    {
        $user = Auth::user();

        return $user->orders()->get();
    }

    public function findByOrderUserId(string $orderId)
    {
        $user = Auth::user();

        return $user->orders()->where('id', $orderId)->first();
    }

    public function create(array $dataValidated)
    {  
        return Order::create($dataValidated);
    }

    public function createOrderItem(string $orderId, string $productId, int $quantity, string $unitPrice)
    {
        return OrderItem::create([
            'orderId' => $orderId,
            'productId' => $productId,
            'quantity' => $quantity,
            'unitPrice' => $unitPrice
        ]);
    }

    public function findOrderById(string $orderId)
    {
        return Order::find($orderId);
    }

    public function update(Order $order, string $newStatus)
    {
        $order->status = $newStatus;
        $order->save();

        return $order;
    }


}