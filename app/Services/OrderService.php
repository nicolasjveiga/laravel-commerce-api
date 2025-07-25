<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use App\Repositories\OrderRepository;
use App\Models\Product;

class OrderService
{
    protected $orderRepo;

    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function createOrder(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = Auth::user();
            $cart = Cart::where('user_id', $user->id)->with('items.product.discounts')->firstOrFail();

            $this->validateCart($cart);

            $total = $this->calculateTotal($cart, $data['coupon_id'] ?? null);

            $order = $this->orderRepo->createOrder([
                'user_id'     => $user->id,
                'address_id'  => $data['address_id'],
                'coupon_id'   => $this->coupon?->id,
                'orderDate'   => now(),
                'status'      => 'PENDING',
                'totalAmount' => $total,
            ]);

            $this->orderRepo->attachOrderItems($order, $cart->items);
            $this->orderRepo->clearCartItems($cart);
            $this->orderRepo->decreaseStockForOrder($order);

            return $order->load('items.product', 'coupon');
        });
    }

    private ?Coupon $coupon = null;

    private function validateCart($cart): void
    {
        if ($cart->items->isEmpty()) {
            abort(400, 'Cart is empty');
        }

        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                abort(400, "Product {$item->product->name} does not have enough stock");
            }
        }
    }

    private function calculateTotal($cart, ?int $couponId): float
    {
        $total = 0;

        foreach ($cart->items as $item) {
            $price = $item->product->price;
            $discount = $item->product->discounts
                ->where('startDate', '<=', now())
                ->where('endDate', '>=', now())
                ->sortByDesc('discountPercentage')
                ->first();

            if ($discount) {
                $price *= (1 - floatval($discount->discountPercentage) / 100);
            }

            $total += $price * $item->quantity;
        }

        $this->coupon = $this->orderRepo->getValidCoupon($couponId);

        if ($this->coupon) {
            $total *= (1 - floatval($this->coupon->discountPercentage) / 100);
        }

        return $total;
    }

    public function cancelOrder(Order $order)
    {
        if (Auth::id() !== $order->user_id) {
            abort(403, 'Unauthorized action.');
        }

        if (in_array($order->status, ['CANCELED', 'COMPLETED'])) {
            abort(400, 'Order cannot be cancelled');
        }

        $this->orderRepo->cancelOrder($order);
        $this->orderRepo->restoreStockForOrder($order);
    }

    public function updateOrderStatus(Order $order, string $status)
    {          
        $updatedStatus = $this->orderRepo->updateOrderStatus($order, $status);

        if ($updatedStatus->status === 'CANCELED') {
            $this->orderRepo->restoreStockForOrder($updatedStatus);
        }

        return $updatedStatus;    
    }

    public function getAllOrders()
    {
        return $this->orderRepo->getAllOrders()->map(function ($order) {
            $order->items = $order->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'unitPrice'  => $item->unitPrice,
                ];
            });
            return $order;
        });
    }
}
