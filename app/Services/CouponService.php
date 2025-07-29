<?php

namespace App\Services;

use App\Models\Coupon;
use App\Repositories\CouponRepository;

class CouponService
{
    protected $couponRepo;
    
    public function __construct(CouponRepository $couponRepo)
    {
        $this->couponRepo = $couponRepo;
    }

    public function listAll()
    {
        return $this->couponRepo->all();
    }

    public function show(Coupon $coupon)
    {
        return $this->couponRepo->find($coupon->id);
    }

    public function create(array $data): Coupon
    {
        return $this->couponRepo->create($data);
    }

    public function update(Coupon $coupon, array $data): Coupon
    {
        return $this->couponRepo->update($coupon, $data);
    }

    public function delete(Coupon $coupon): Coupon
    {
        $this->couponRepo->delete($coupon);
        return $coupon;
    }
}
