<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'discountPercentage' => $this->discountPercentage,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ];
    }
}
