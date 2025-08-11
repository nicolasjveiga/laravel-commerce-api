<?php

namespace App\Http\Controllers\Cart;

use App\Models\Order;
use App\Services\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateStatusRequest;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    
    public function index()
    {
        $this->authorize('viewAny', Order::class);

        $orders = $this->orderService->getAllOrders();

        return OrderResource::collection($orders);
    }

    public function store(StoreOrderRequest $request)
    {
        $this->authorize('create', Order::class);

        $validated = $request->validated();
        
        $order = $this->orderService->createOrder($validated);
        
        return new OrderResource($order);
    }

    public function updateStatus(UpdateStatusRequest $request, Order $order)
    {
        $this->authorize('update', $order);

        $validated = $request->validated();
        
        $order = $this->orderService->updateOrderStatus($order, $validated['status']);
        
        return new OrderResource($order);
    }

    public function cancel(Order $order)
    {
        $this->authorize('cancel', $order);

        $this->orderService->cancelOrder($order);
        
        return response()->json(null, 204);
    }
}
