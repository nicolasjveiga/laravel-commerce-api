<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'stock', 'price'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function discounts(){
        return $this->hasMany(Discount::class);
    }

    public function cartItems(){
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
}
