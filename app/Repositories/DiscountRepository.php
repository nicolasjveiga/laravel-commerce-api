<?php

namespace App\Repositories;

use App\Models\Discount;

class DiscountRepository
{
    public function all()
    {
        return Discount::all();
    }

    public function create(array $data): Discount
    {
        return Discount::create($data);
    }

    public function update(Discount $discount, array $data): Discount
    {
        $discount->update($data);
        return $discount;
    }

    public function delete(Discount $discount): void
    {
        $discount->delete();
    }
}