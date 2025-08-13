<?php

namespace Tests\Unit;

use Mockery;
use ReflectionClass;
use App\Models\Cart\Cart;
use App\Models\Catalog\Product;
use App\Models\Discount\Discount;
use App\Models\Cart\CartItem;
use App\Services\OrderService;
use PHPUnit\Framework\TestCase;
use App\Services\PricingService;
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

        $mockPricing = Mockery::mock(PricingService::class);
        $mockPricing->shouldReceive('applyProductDiscount')
            ->once()
            ->with($product)
            ->andReturn(80);

        $mockPricing->shouldReceive('applyCoupon')
            ->once()
            ->with(160, null)
            ->andReturn(160);

        $orderService = new OrderService($mockRepo, $mockPricing);

        $ref = new \ReflectionClass($orderService);
        $method = $ref->getMethod('calculateTotal');
        $method->setAccessible(true);

        $total = $method->invokeArgs($orderService, [$cart, null]);

        $this->assertEquals(160, $total);
    }

}
