<?php

namespace App\Repositories\Cart;

use App\Models\Cart\Order;

class OrderRepository
{

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
        return Order::with('items.product')->get();
    }
}
