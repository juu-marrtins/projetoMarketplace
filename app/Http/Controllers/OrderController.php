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

        $orders = $this->orderService->getAllOrders();

        if(!$orders)
        {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum pedido enconrtado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $orders
        ], 200);
    }

    public function store(StoreOrderRequest $request)  
    {
        $order = $this->orderService->createOrder($request->validated());

        if(!$order)
        {
            return response()->json([
                'success' => false,
                'message' => 'Pedido nao encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pedido criado com sucesso!',
            'data' => $order
        ], 201);
    }

    public function orderByUser()
    {
        $orders = $this->orderService->getAllOrdersOfAuthenticatedUser();

        if (!$orders) {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum pedido encontrado para o usuario autenticado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $orders
        ], 200);
    }

    public function orderById(string $orderId)
    {
        $order = $this->orderService->getOrderById($orderId);
        if(!$order)
        {
            return response()->json([
                'success' => false,
                'message' => 'Pedido nao encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order
        ], 200);
    }


    public function update(UpdateOrderRequest $request, string $orderId)
    {
        $dataValidated = $request->validated();
        $order = $this->orderService->updateStatusOrder($orderId, $dataValidated['status']);
        
        if(!$order)
        {
            return response()->json([
                'success' => false,
                'message' => 'Pedido nao encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status atualizado com sucesso!',
            'data' => $order
        ], 200);
    }

    public function destroy(DestroyOrderRequest $request)
    {   
        $dataValidated = $request->validated();
        $order = $this->orderService->deleteOrder($dataValidated['orderId']);
        if(!$order)
        {
            return response()->json([
                'success' => false,
                'message' => 'Pedido nao encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pedido excluido com sucesso!',
        ], 200);
    }
}
