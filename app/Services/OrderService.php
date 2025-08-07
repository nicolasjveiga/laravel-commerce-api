<?php

namespace App\Services;

use PrincingService;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderRepository;
use App\Exceptions\Order\CartEmptyException;
use App\Exceptions\Order\InsufficientStockException;
use App\Exceptions\Order\OrderCancellationException;
use App\Exceptions\Order\UnauthorizedOrderActionException;

class OrderService
{
    protected $orderRepo;
    protected $pricingService;

    public function __construct(OrderRepository $orderRepo, PricingService $pricingService)
    {
        $this->orderRepo = $orderRepo;
        $this->pricingService = $pricingService;
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
                'coupon_id'   => $this->pricingService->getAplliedCoupon()?->id,
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
            throw new CartEmptyException();
        }

        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                throw new InsufficientStockException($item->product);
            }
        }
    }

    private function calculateTotal($cart, ?int $couponId): float
    {
        $total = 0;

        foreach ($cart->items as $item) {
            $price = $this->pricingService->applyProductDiscount($item->product);
            $total += $price * $item->quantity;
        }

        $total = $this->pricingService->applyCoupon($total, $couponId); 

        return $total;
    }

    public function cancelOrder(Order $order, string $originalStatus = null)
    {
        $status = $originalStatus ?? $order->status;

        if (in_array($status, ['CANCELED', 'COMPLETED'])) {
            throw new OrderCancellationException();
        }

        $this->orderRepo->cancelOrder($order);
        $this->orderRepo->restoreStockForOrder($order);
    }

    public function updateOrderStatus(Order $order, string $status)
    {          
        $originalStatus = $order->status;

        $updatedStatus = $this->orderRepo->updateOrderStatus($order, $status);

        if ($status === 'CANCELED') {
            $this->cancelOrder($order, $originalStatus);
        }

        return $updatedStatus;    
    }

    public function getAllOrders()
    {
        return $this->orderRepo->getAllOrders();
    }
}
