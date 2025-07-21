<?php

namespace App\Http\Services;

use App\Http\Repository\OrderRepository;
use App\Models\Coupon;
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
        $cart = Auth::user()->cart()->with('items.product.discounts')->first();

        $totalOrder = 0;

        foreach ($cart->items as $item) 
        {
            $product = $item->product;
            $discount = $product->discounts->firstWhere('endDate', '>=', now());

            $subtotal = $item->quantity * $item->unitPrice;

            if ($discount) {
                $subtotal = $this->getDiscount($subtotal, $discount);
            }

            $this->orderRepository->createOrderItem(
                $order->id,
                $item->productId,
                $item->quantity,
                $item->unitPrice
            );

            $totalOrder += $subtotal;
        }

        $coupon = $order->coupon;

        if ($coupon && $coupon->endDate >= now()) 
        {
            $totalOrder = $this->getCoupon($totalOrder, $coupon);
        }
        $order->totalAmount = $totalOrder;
        $order->save();

        return $totalOrder;
    }

    public function getCoupon(float $totalOrder, Coupon $coupon)
    {
        $amountCoupon = $totalOrder * ($coupon->discountPercentage/100);
        return $totalOrder - $amountCoupon;
    }

    public function getDiscount(float $subtotal, $discount)
    {
        $amountDiscount = $subtotal * ($discount->discountPercentage / 100);
        return $subtotal - $amountDiscount;
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