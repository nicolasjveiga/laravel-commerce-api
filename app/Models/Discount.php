<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use HasFactory;
    
    protected $fillable = ['product_id', 'description', 'startDate', 'endDate', 'discountPercentage'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
