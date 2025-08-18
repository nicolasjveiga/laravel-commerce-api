<?php

namespace App\Policies\Auth;

use App\Models\User\User;

class AuthPolicy
{
    public function registerMod(User $user)
    {
        return $user->isAdmin();
    }
}