<?php

namespace App\Http\Services;

use App\Enums\OrderCreateOrderStatus;
use App\Http\Repository\OrderRepository;
use App\Http\Services\Address\AddressService;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function __construct(
        protected OrderRepository $orderRepository,
        protected AddressService $addressService)
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

    public function getAllOrdersOfAuthenticatedUser(int $userId)
    {
        $orders = $this->orderRepository->getAllByUserId($userId);

        return $orders->isEmpty() ? null : $orders;
    }

    public function createOrder(array $dataValidated, User $user)
    {   
        if(!$user->cart)
        {
            return OrderCreateOrderStatus::CART_NOT_FOUND;
        }
        $dataValidated['userId'] = $user->id;

        if(!$this->confirmAddress($dataValidated['addressId'], $user) === OrderCreateOrderStatus::ADDRESS_FOUND)
        {
            return OrderCreateOrderStatus::ADDRESS_NOT_FOUND;
        }

        $dataValidated['status'] = 'PENDING';
        $dataValidated['orderDate'] = now();    
        $dataValidated['totalAmount'] = 0;
        
        if($user->cart->items()->count() <= 0){
            return OrderCreateOrderStatus::CART_EMPTY;
        }

        $order = $this->orderRepository->create($dataValidated);

        $orderItemCreate = $this->createOrderItem($order, $user);

        if (
            (!is_array($orderItemCreate) && $orderItemCreate != OrderCreateOrderStatus::SUCCESS) ||
            (is_array($orderItemCreate) && $orderItemCreate[0] != OrderCreateOrderStatus::ORDER_SUCCESS_WITHOUT_DISCOUNT)
        ) {
            return $orderItemCreate;
        }

        return $order;
    }

    public function confirmAddress(string $addressId, User $user) 
    {
        if(!$this->addressService->getAddressByUserAndId($user, $addressId))
        {
            return OrderCreateOrderStatus::ADDRESS_NOT_FOUND;
        }
        return OrderCreateOrderStatus::ADDRESS_FOUND;
    }

    public function createOrderItem(Order $order, User $user)
    {
        $cart = $user->cart()->with('items.product.discounts')->first();

        $totalOrder = 0;

        foreach ($cart->items as $item) 
        {
            $product = $item->product;

            $successDecrement = $this->decrementProduct($product, $item);

            if($successDecrement != OrderCreateOrderStatus::SUCCESS)
            {
                return $successDecrement;
            }

            $discount = $product->discounts->firstWhere('endDate', '>=', now());

            $subtotal = $item->quantity * $item->unitPrice;

            if ($discount) {
                $subtotal = $this->getDiscount($subtotal, $discount);
                $discountUse = true;
            } else {
                $discountUse = false;
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

        $this->orderRepository->updateTotalAmount($order, $totalOrder);

        $user->cart->items()->delete();

        if(!$discountUse)
        {
            return [OrderCreateOrderStatus::ORDER_SUCCESS_WITHOUT_DISCOUNT, $order];
        }
        return OrderCreateOrderStatus::SUCCESS;
    }

    public function decrementProduct(Product $product, CartItem $item) 
    {

        if($product->stock < $item->quantity)
        {
            return OrderCreateOrderStatus::STOCK_NOT_ENOUGH;
        }

        $newStock = $product->stock -= $item->quantity;

        $this->orderRepository->updateStockProduct($product, $newStock);

        return OrderCreateOrderStatus::SUCCESS;
    }

    public function restoreStock(string $orderId) : ?bool
    {
        $order = $this->orderRepository->findOrderById($orderId);
        
        if (!$order) {
            return null;
        }
        foreach ($order->orderItems as $item) {
            $product = $item->product;
            if ($product) {
                $newStock = $product->stock += $item->quantity;
                $this->orderRepository->updateStockProduct($product, $newStock);
            }
        }
        return true;
    }

    public function getCoupon(float $totalOrder, Coupon $coupon) : float
    {
        $amountCoupon = $totalOrder * ($coupon->discountPercentage/100);
        return $totalOrder - $amountCoupon;
    }

    public function getDiscount(float $subtotal, $discount) : float
    {
        $amountDiscount = $subtotal * ($discount->discountPercentage / 100);
        return $subtotal - $amountDiscount;
    }


    public function getOrderById(string $orderId, int $userId) 
    {
        $order = $this->orderRepository->findByUserAndId($userId, $orderId);

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

    public function userCancelOrder(string $orderId) 
    {
        $order = $this->orderRepository->findByUserAndId(Auth::id(), $orderId);

        if(!$order) {
            return OrderCreateOrderStatus::ORDER_NOT_FOUND;
        }

        if($order->status === 'CANCELED')
        {
            return OrderCreateOrderStatus::ORDER_ALREADY_CANCELED;
        }

        $newStatus = 'CANCELED';

        $this->orderRepository->update($order, $newStatus);

        $this->restoreStock($orderId);
        
        return OrderCreateOrderStatus::SUCCESS;
    }
}