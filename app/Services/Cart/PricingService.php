<?php

namespace App\Services\Cart;

use App\Models\Discount\Coupon;
use App\Models\Catalog\Product;
use App\Exceptions\Order\InvalidCouponException;

class PricingService
{
    private ?Coupon $coupon = null;

    public function applyProductDiscount(Product $product): float
    {
        $discount = $product->discounts
            ->where('startDate', '<=', now())
            ->where('endDate', '>=', now())
            ->sortByDesc('discountPercentage')
            ->first();

        $price = $product->price;

        if ($discount) {
            $price *= (1 - floatval($discount->discountPercentage) / 100);
        }

        return $price;
    }

    public function applyCoupon(float $total, ?int $couponId): float
    {
        if (!$couponId){
            return $total;
        }

        $coupon = Coupon::find($couponId);

        if(!$coupon || $coupon->startDate > now() || $coupon->endDate < now()) {
            throw new InvalidCouponException();
        }

        $this->coupon = $coupon;

        return $total * (1 - floatval($coupon->discountPercentage) / 100);
    }

    public function getAplliedCoupon(): ?Coupon
    {
        return $this->coupon;
    }

}