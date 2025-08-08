<?php

namespace App\Exceptions\Order;

use Exception;

class OrderCancellationException extends Exception
{
    public function render($request){
        return response()->json([
            'message' => 'Order cannot be cancelled'
        ], 400);
    }
}
