<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Services\OrderService;
use App\Models\Order;


class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    
    public function index()
    {
        $orders = $this->orderService->getAllOrders();
        return response()->json($orders);
    }

    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();
        $order = $this->orderService->createOrder($validated);
        
        return response()->json($order, 201);
    }

    public function cancel(Order $order){
        $this->orderService->cancelOrder($order);
        
        return response()->json(null, 204);    
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:PENDING,PROCESSING,SHIPPED,COMPLETED,CANCELED',
        ]);

        $order = $this->orderService->updateOrderStatus($order, $validated['status']);
        
        return response()->json($order);
    }
}
