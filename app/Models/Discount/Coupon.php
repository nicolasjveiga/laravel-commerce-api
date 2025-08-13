<?php

namespace App\Models\Discount;

use App\Models\Cart\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'startDate', 'endDate', 'discountPercentage'];
    
    public function orders(){
        return $this->hasMany(Order::class);
    }
}
