<?php

namespace App\Http\Services;

use App\Http\Repository\OrderRepository;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function __construct(protected OrderRepository $orderRepository)
    {}

    public function getAllOrders()
    {
        return $this->orderRepository->all();
    }

    public function getOrderByUser()
    {
        return $this->orderRepository->findByUser();
    }

    public function createOrder(array $dataValidated)
    {   
        $dataValidated['userId'] = Auth::user()->id;
        $dataValidated['orderDate'] = now();
        $order =  $this->orderRepository->create($dataValidated);
        $this->createOrderItem($order);
        return $order;
    }

        public function createOrderItem(Order $order)
    {
        $cart = Auth::user()->cart()->with('items.product.discounts');

        $totalOrder = 0;

        foreach ($cart->items as $item) // ERRO AQUI CORRIIGIR
        {
            $product = $item->product;
            $discount = $product->discounts->firstWhere('endDate', '>=', now());

            $subtotal = $item->quantity * $item->unitPrice;

            if ($discount) {
                $amountDiscount = $subtotal * ($discount->discountPercentage / 100);
                $subtotal -= $amountDiscount;
            }

            $this->orderRepository->createOrderItem(
                $order->id,
                $item->productId,
                $item->quantity,
                $item->unitPrice
            );

            $totalOrder += $subtotal;
        }

        $order->totalAmount = $totalOrder;
        $order->save();

        return $totalOrder;
    }


    public function getOrderById(string $orderId)
    {
        $order = $this->orderRepository->findByOrderUserId($orderId);

        if(!$order){
            return "Pedido nao encontrado";
        }

        return $order;
    }

    public function updateStatusOrder(string $orderId, string $newStatus)
    {
        $order = $this->orderRepository->findOrderById($orderId);
        if(!$order)
        {
            return "Pedido nao encontrado";
        }

        return $this->orderRepository->update($order, $newStatus);
    }

    public function deleteOrder(string $orderId)
    {
        $orders = $this->orderRepository->findByUser();
        
        $orderDelete = $orders->where('id', $orderId)->first();

        if(!$orderDelete)
        {
            return "Pedido nao encontrado";
        }
        
        $orderDelete->delete();

        return "Pedido cancelado com sucesso!";
    }

}