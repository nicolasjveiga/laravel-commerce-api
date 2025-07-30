<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Auth\Access\Response;

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