<?php

namespace App\Exceptions\Order;

use Exception;

class CartEmptyException extends Exception
{
    public function render($request){
        return response()->json([
            'message' => 'Cart is empty'
        ], 400);
    }
}
