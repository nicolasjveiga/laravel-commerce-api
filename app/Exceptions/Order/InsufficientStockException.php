<?php

namespace App\Exceptions\Order;

use Exception;
use App\Models\Catalog\Product;


class InsufficientStockException extends Exception
{
    protected $product;

    public function __construct(Product $product) {
        parent::__construct();
        $this->product = $product;
    }

    public function render($request) {
        return response()->json([
            'message' => "Product '{$this->product->name}' does not have enough stock"
        ], 400);
    }
}
