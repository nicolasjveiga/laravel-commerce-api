<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateStatusRequest;

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
        
        return response()->json($orders, 200);
    }

    public function store(StoreOrderRequest $request)
    {
        $this->authorize('create', Order::class);

        $validated = $request->validated();
        
        $order = $this->orderService->createOrder($validated);
        
        return response()->json($order, 201);
    }

    public function updateStatus(UpdateStatusRequest $request, Order $order)
    {
        $this->authorize('update', $order);

        $validated = $request->validated();
        
        $order = $this->orderService->updateOrderStatus($order, $validated['status']);
        
        return response()->json($order, 200);
    }

    public function cancel(Order $order)
    {
        $this->authorize('cancel', $order);

        $this->orderService->cancelOrder($order);
        
        return response()->json(null, 204);    
    }
}
