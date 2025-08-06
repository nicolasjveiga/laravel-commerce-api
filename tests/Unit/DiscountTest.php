<?php

namespace Tests\Unit;

use Mockery;
use ReflectionClass;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Discount;
use App\Models\CartItem;
use App\Services\OrderService;
use PHPUnit\Framework\TestCase;
use App\Repositories\OrderRepository;

class DiscountTest extends TestCase
{
    public function test_discount_calculation_is_correct()
    {
        $product = new Product(['price' => 100]);
        $product->setRelation('discounts', collect([
            new Discount([
                'discountPercentage' => 20,
                'startDate' => now()->subDay(),
                'endDate' => now()->addDay()
            ])
        ]));

        $cartItem = new CartItem(['quantity' => 2]);
        $cartItem->setRelation('product', $product);

        $cart = new Cart();
        $cart->setRelation('items', collect([$cartItem]));

        $mockRepo = Mockery::mock(OrderRepository::class);
        $mockRepo->shouldReceive('getValidCoupon')->andReturn(null);

        $orderService = new OrderService($mockRepo);

        $ref = new ReflectionClass($orderService);
        $method = $ref->getMethod('calculateTotal');
        $method->setAccessible(true);

        $total = $method->invokeArgs($orderService, [$cart, null]);

        $this->assertEquals(160, $total);
    }
}
