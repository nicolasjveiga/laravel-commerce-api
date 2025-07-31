<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;

class OrderPolicy
{
    public function viewAny(User $user)
    {
        return $user->isMod();
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Order $order)
    {
        return $user->isMod();
    }

    public function cancel(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }
}