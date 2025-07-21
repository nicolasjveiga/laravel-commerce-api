<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class OrderRepository
{

    public function getValidCoupon(?int $couponId)
    {
        if (!$couponId) return null;

        return Coupon::where('id', $couponId)
            ->where('startDate', '<=', now())
            ->where('endDate', '>=', now())
            ->first();
    }

    public function createOrder(array $data): Order
    {
        return Order::create($data);
    }

    public function attachOrderItems(Order $order, $cartItems)
    {
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unitPrice' => $item->unitPrice,
                'discount' => $item->discount ?? 0,
            ]);
        }
    }

    public function clearCartItems($cart)
    {
        $cart->items()->delete();
    }

    public function cancelOrder(Order $order)
    {
        $order->update(['status' => 'CANCELED']);
    }

    public function updateOrderStatus(Order $order, string $status)
    {
        $order->update(['status' => $status]);
        return $order->fresh();
    }

    public function decreaseStockForOrder(Order $order)
    {
        foreach ($order->items as $item) {
            $product = $item->product;
            $product->stock -= $item->quantity;
            $product->save();
        }
    }

    public function restoreStockForOrder(Order $order)
    {
        foreach ($order->items as $item) {
            $product = $item->product;
            $product->stock += $item->quantity;
            $product->save();
        }
    }

    public function getAllOrders()
    {
        return Order::with(['items' => function ($query) {
            $query->select('id', 'order_id', 'product_id', 'quantity', 'unitPrice');
        }])->get();
    }
}
