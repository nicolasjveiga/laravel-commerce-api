<?php

namespace App\Exceptions\Order;

use Exception;

class UnauthorizedOrderActionException extends Exception
{
    public function render($request){
        return response()->json([
            'message' => 'Unauthorized order action'
        ], 400);
    }
}
