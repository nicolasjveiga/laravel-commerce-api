<?php

namespace App\Policies\Cart;

use App\Models\User\User;
use App\Models\Cart\Order;

class OrderPolicy
{
    public function viewAny(User $user)
    {
        return $user->isMod();
    }

    public function create()
    {
        return true;
    }

    public function update(User $user)
    {
        return $user->isMod();
    }

    public function cancel(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }
}