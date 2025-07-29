<?php

namespace App\Policies;

use App\Models\Coupon;
use App\Models\User;


class CouponPolicy
{
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    public function view(User $user, Coupon $coupon)
    {
        return $user->isAdmin();
    }
    
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, Coupon $coupon)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Coupon $coupon)
    {
        return $user->isAdmin();
    }

}