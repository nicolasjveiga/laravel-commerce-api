<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'unitPrice' => $this->unitPrice,
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'stock' => $this->product->stock,
                'price' => $this->product->price,
                'image' => $this->product->image,
            ],
        ];
    }
}
