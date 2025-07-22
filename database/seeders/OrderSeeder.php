<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\OrderItem;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['PENDING', 'PROCESSING', 'SHIPPED', 'COMPLETED', 'CANCELED'];

        for ($i = 0; $i < 20; $i++) {
            $user = User::inRandomOrder()->first();

            $address = $user->addresses()->inRandomOrder()->first();

            if (!$address) {
                continue;
            }
            
            $daysAgo = rand(0, 30);
            $orderDate = Carbon::now()->subDays($daysAgo)->setTime(rand(8, 18), rand(0, 59));

            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'coupon_id' => null,
                'orderDate' => $orderDate,
                'status' => collect($statuses)->random(),
                'totalAmount' => 0,
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ]);

            $total = 0;

            $products = Product::inRandomOrder()->limit(rand(1, 5))->get();

            foreach ($products as $product) {
                $quantity = rand(1, 3);
                $price = $product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unitPrice' => $price,
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);

                $total += $price * $quantity;
            }

            $order->update(['totalAmount' => $total]);
        }
    }
}
