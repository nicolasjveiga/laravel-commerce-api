<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'createdAt'];

    public function user(){
        return $this->belongTo(User::class);
    }

    public function items(){
        return $this->hasMany(CartItem::class);
    }
}
