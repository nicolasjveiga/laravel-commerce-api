<?php 

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as CARBON;
use App\Models\Cart;

class OrderService
{

    public function createOrder(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = Auth::user();
            $cart = Cart::where('user_id', $user->id)->with('items.product.discounts')->firstOrFail();

            $total = 0;

            foreach ($cart->items as $item) {
                $price = $item->product->price;
                $discount = $item->product->discounts
                        ->where('startDate', '<=', now())
                        ->where('endDate', '>=', now())
                        ->sortByDesc('discountPercentage')
                        ->first();

                $total += $item->unitPrice * $item->quantity;
                if (isset($item->product->discount)) {
                    $total -= ($item->product->discount / 100) * $total;
                }
            }

            if($discount){
                $price = $price * (1 - $discount->discountPercentage / 100);
            }

            $coupon = null;
            if(!empty($data['coupon_id'])) {
                $coupon = Coupon::where('id', $data['coupon_id'])
                    ->where('startDate', '<=', now())
                    ->where('endDate', '<=', now())
                    ->first();
            }

            if($coupon) {
                $total *= (1 - $coupon->discountPercentage / 100);
            }

            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $data['address_id'],
                'coupon_id' => $coupon_id ?? null,
                'orderDate' => CARBON::now(),
                'status' => 'PENDING',
                'totalAmount' => $total
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unitPrice' => $item->unitPrice,
                    'discount' => $item->discount ?? 0,
                ]);
            }

            $cart->items()->delete();

            return $order->load('items.product', 'coupon');
        });

    }

    public function cancelOrder(Order $order)
    {
        if (Auth::user()->id !== $order->user_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($order->status === 'CANCELED'|| $order->status === 'COMPLETED') {
            abort(400, 'Order cannot be cancelled');
        }

        $order->update(['status' => 'CANCELED']);
    }

    public function updateOrderStatus(Order $order, string $status){
        $order->update(['status' => $status]);
    }


    public function getAllOrders()
    {
        return Order::with(['items' => function($query) {
        $query->select('id', 'order_id', 'product_id', 'quantity', 'unitPrice');
        }])->get()->map(function($order) {
            $order->items = $order->items->map(function($item) {
                return [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unitPrice' => $item->unitPrice,
                ];
            });
        return $order;
    });
}
}