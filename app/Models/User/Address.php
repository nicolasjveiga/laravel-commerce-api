<?php

namespace App\Models\User;

use App\Models\Cart\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'street', 'number', 'city', 'state', 'country', 'latitude', 'longitude'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
