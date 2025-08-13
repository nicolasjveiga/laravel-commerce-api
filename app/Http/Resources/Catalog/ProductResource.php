<?php

namespace App\Http\Resources\Catalog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'category' => $this->category->name,
            'name' => $this->name,
            'stock' => $this->stock,
            'price' => $this->price,
            'image' => $this->image
        ];
    }
}
