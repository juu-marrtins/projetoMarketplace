<?php

namespace App\Http\Repository;

use App\Models\Order;
use App\Models\OrderItem;


class OrderRepository
{
    public function all()
    {
        return Order::all();
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

    public function findByUserAndId(string $userId, string $orderId)
    {
        return Order::where('userId', $userId)
                    ->where('id', $orderId)
                    ->first();
    }

        public function getAllByUserId(string $userId)
    {
        return Order::where('userId', $userId)->get();
    }
}