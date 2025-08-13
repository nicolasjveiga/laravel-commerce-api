<?php

namespace App\Models\Cart;

use App\Models\User\User;
use App\Models\Discount\Coupon;
use App\Models\User\Address;
use App\Models\Cart\OrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'address_id', 'coupon_id', 'orderDate', 'status', 'totalAmount'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function coupon(){
        return $this->belongsTo(Coupon::class);
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }
}
