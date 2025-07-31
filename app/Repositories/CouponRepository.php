<?php

namespace App\Repositories;

use App\Models\Coupon;

class CouponRepository
{
    public function all()
    {
        return Coupon::all();
    }

    public function find(int $id)
    {
        return Coupon::find($id);
    }

    public function create(array $data): Coupon
    {
        return Coupon::create($data);
    }

    public function update(Coupon $coupon, array $data): Coupon
    {
        $coupon->update($data);
        return $coupon;
    }

    public function delete(Coupon $coupon): void
    {
        $coupon->delete();
    }
}