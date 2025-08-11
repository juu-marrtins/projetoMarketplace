<?php

namespace App\Http\Controllers;

use App\Enums\OrderCreateOrderStatus;
use App\Helpers\ApiResponse;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {}

    public function allOrders()
    {

        $orders = $this->orderService->getAllOrders();

        if(!$orders)
        {
            return ApiResponse::fail(
                'Nenhum pedido encontrado.',
                404
            );
        }

        return ApiResponse::success(
            'Listagem de todos os pedidos.',
            OrderResource::collection($orders),
            200
        );
    }

    public function store(StoreOrderRequest $request)  
    {
        $order = $this->orderService->createOrder($request->validated(), Auth::user());

        if($order === OrderCreateOrderStatus::DISCOUNT_INVALID)
        {
            return ApiResponse::fail('Desconto inserido inválido.', 409);
        }
        if($order === OrderCreateOrderStatus::STOCK_NOT_ENOUGH)
        {
            return ApiResponse::fail('Produto não possue estoque suficiente.',409);
        }
        if($order === OrderCreateOrderStatus::CART_EMPTY)
        {
            return ApiResponse::fail('Não é possivel criar um pedido com o carrinho vazio.', 409);
        }
        if($order === OrderCreateOrderStatus::ADDRESS_NOT_FOUND)
        {
            return ApiResponse::fail('Endereco inválido.', 409);
        }
        if($order === OrderCreateOrderStatus::CART_NOT_FOUND)
        {
            return ApiResponse::fail('Carrinho não encontrado', 404);
        }
        if($order[0]  === OrderCreateOrderStatus::ORDER_SUCCESS_WITHOUT_DISCOUNT)
        {
            return ApiResponse::success(
                'Pedido criado, mas sem o uso de cupom.',
                new OrderResource($order[1]),
                201
            );
        }
        return ApiResponse::success(
            'Pedido criado com sucesso.',
            new OrderResource($order),
            201
        );
    }

    public function orderByUser()
    {
        $orders = $this->orderService->getAllOrdersOfAuthenticatedUser(Auth::id());

        if (!$orders) {
            return ApiResponse::fail(
                'Nenhum pedido encontrado para o usuario autenticado.',
                404
            );
        }

        return ApiResponse::success(
            'Pedidos do usuário.',
            OrderResource::collection($orders),
            200
        );
    }

    public function orderById(string $orderId)
    {
        $order = $this->orderService->getOrderById($orderId, Auth::id());
        if(!$order)
        {
            return ApiResponse::fail(
                'Pedido não encontrado.',
                404
            );
        }

        return ApiResponse::success(
            'Pedido por id',
            new OrderResource($order),
            200
        );
    }

    public function update(UpdateOrderRequest $request, string $orderId)
    {
        $dataValidated =  $request->validated();
        $order = $this->orderService->updateStatusOrder($orderId, $dataValidated['status']);
        
        if(!$order)
        {
            return ApiResponse::fail(
                'Pedido não encontrado.',
                404
            );
        }

        return ApiResponse::success(
            'Status atualizado.',
            new OrderResource($order),
            200
        );
    }

    public function cancelOrder(string $orderId)
    {   
        $order = $this->orderService->userCancelOrder($orderId);

        if($order === OrderCreateOrderStatus::ORDER_NOT_FOUND)
        {
            return ApiResponse::fail(
                'Pedido não encontrado.',
                404
            );
        }
        if($order === OrderCreateOrderStatus::ORDER_ALREADY_CANCELED)
        {
            return ApiResponse::fail(
                'O pedido já esta cancelado',
                409
            );
        }

        return response()->noContent();
    }
}
