<?php

namespace App\Exceptions\Order;

use Exception;

class InvalidCouponException extends Exception
{
    public function render($request){
        return response()->json([
            'message' => 'The provided coupon is invalid or expired.'
        ], 400);
    }
}
