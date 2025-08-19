<?php

namespace App\Exceptions\Product;

use Exception;

class ProductInOrderException extends Exception
{
    public function render($request){
        return response()->json([
            'message' => 'Cannot delete product that exists in an order.'
        ], 400);
    }
}
