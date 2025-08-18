<?php

namespace App\Models\User;

use App\Models\Cart\Cart;
use App\Models\Cart\Order;
use App\Models\User\Address;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isAdmin()
    {
        return $this->role === 'ADMIN';
    }

    public function isMod()
    {
        return $this->role === 'MODERATOR';
    }

    public function isSelf(User $user)
    {
        return $this->id === $user->id;
    }

}
