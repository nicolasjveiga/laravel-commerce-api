<?php

namespace App\Policies;

use App\Models\Cart\Cart;
use App\Models\User\User;

class CartPolicy
{
    public function index(User $user, Cart $cart)
    {
        return $user->id === $cart->user_id;
    }

    public function addItem(User $user, Cart $cart)
    {
        return $user->id === $cart->user_id;
    }

    public function update(User $user, Cart $cart)
    {
        return $user->id === $cart->user_id;
    }

    public function destroy(User $user, Cart $cart)
    {
        return $user->id === $cart->user_id;
    }

    public function clear(User $user, Cart $cart)
    {
        return $user->id === $cart->user_id;
    }
}