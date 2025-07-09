<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'role'];

    public function addresses(){
        return $this->hasMany(Address::class);
    }

    public function cart(){
        return $this->hasOne(Carts::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
