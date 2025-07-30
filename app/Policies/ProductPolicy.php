<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function viewANy(?User $user)
    {
        return true;
    }

    public function view(?User $user, Product $product)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->isMod();
    }
    
    public function update(User $user, Product $product)
    {
        return $user->isMod();
    }

    public function delete(User $user, Product $product)
    {
        return $user->isMod();
    }
}