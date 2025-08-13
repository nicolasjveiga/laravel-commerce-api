<?php

namespace App\Http\Resources\Discount;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'description' => $this->description,
            'discountPercentage' => $this->discountPercentage,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ];
    }
}
