<?php

namespace App\Services;

use App\Models\Discount;
use App\Repositories\DiscountRepository;

class DiscountService
{
    protected $discountRepo;

    public function __construct(DiscountRepository $discountRepo)
    {
        $this->discountRepo = $discountRepo;
    }

    public function listAll()
    {
        return $this->discountRepo->all();
    }

    public function create(array $data): Discount
    {
        return $this->discountRepo->create($data);
    }

    public function update(Discount $discount, array $data): Discount
    {
        return $this->discountRepo->update($discount, $data);
    }

    public function delete(Discount $discount):Discount
    {
        $this->discountRepo->delete($discount);
        return $discount;
    }
}