<?php

namespace App\Http\Services;

use App\Http\Repository\OrderRepository;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function __construct(protected OrderRepository $orderRepository)
    {}

    public function getAllOrders()
    {
        $orders = $this->orderRepository->all();

        if(!$orders)
        {
            return null;
        }
        return $orders;
    }

    public function getAllOrdersOfAuthenticatedUser()
    {
        $orders = $this->orderRepository->getAllByUserId(Auth::id());

        return $orders->isEmpty() ? null : $orders;
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

            $this->decrementProduct($product, $item);

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

    public function decrementProduct(Product $product, CartItem $item)
    {
        $product->stock -= $item->quantity;
        $product->save();
    }

    public function restoreStock(string $orderId)
    {
        $order = $this->orderRepository->findOrderById($orderId);
        
        if (!$order) {
            return null;
        }
        foreach ($order->orderItems as $item) {
            $product = $item->product;
            if ($product) {
                $product->stock += $item->quantity;
                $product->save();
            }
        }
        return true;
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
        $order = $this->orderRepository->findByUserAndId(Auth::id(), $orderId);

        if(!$order){
            return null;
        }

        return $order;
    }

    public function updateStatusOrder(string $orderId, string $newStatus)
    {
        $order = $this->orderRepository->findOrderById($orderId);

        if(!$order)
        {
            return null;
        }

        if ($newStatus === 'CANCELED') {
            $success = $this->restoreStock($orderId);
            if (!$success) {
                return null;
            }
        }

        $updateOrder = $this->orderRepository->update($order, $newStatus);

        return $updateOrder;
    }

    public function deleteOrder(string $orderId)
    {
        $orderDelete = $this->orderRepository->findByUserAndId(Auth::id(), $orderId);

        if(!$orderDelete) {
            return null;
        }
        
        $orderDelete->delete();

        return $orderDelete;
    }
}