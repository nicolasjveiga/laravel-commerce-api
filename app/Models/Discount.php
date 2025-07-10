<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = ['product_id', 'description', 'startDate', 'endDate', 'discountPercentage'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
