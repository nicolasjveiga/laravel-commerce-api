<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'address_id' => $this->address_id,
            'coupon_id' => $this->coupon_id,
            'orderDate' => $this->orderDate,
            'status' => $this->status,
            'totalAmount' => $this->totalAmount,
            'items' => $this->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'category' => $item->product->category->name,
                    'name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'unitPrice' => $item->unitPrice,
                    'image' => $item->product->image
                ];  
            }),
        ];
    }
}
