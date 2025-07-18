<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {}

    public function allOrders()
    {
        return response()->json([
            'Orders' => $this->orderService->getAllOrders()
        ], 200);
    }

    public function store(StoreOrderRequest $request)
    {
        return response()->json([
            'message' => $this->orderService->createOrder($request->validated())
        ], 201);
    }

    public function orderByUser()
    {
        return response()->json([
            'Order User' => $this->orderService->getOrderByUser()
        ], 200);
    }

    public function orderById(string $orderId)
    {
        return response()->json([
            'Order By Id' => $this->orderService->getOrderById($orderId)
        ], 200);
    }


    public function update(UpdateOrderRequest $request, string $orderId)
    {
        $dataValidated = $request->validated();
        return response()->json([
            'message' => $this->orderService->updateStatusOrder($orderId, $dataValidated['status'])
        ], 200);
    }

    public function destroy(DestroyOrderRequest $request)
    {   
        $dataValidated = $request->validated();
        return response()->json([
            'message' => $this->orderService->deleteOrder($dataValidated['orderId'])
        ], 200);
    }
}
