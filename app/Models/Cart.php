<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'createdAt'];

    public function user(){
        return $this->belongTo(User::class);
    }

    public function items(){
        return $this->hasMany(CartItem::class);
    }
}
