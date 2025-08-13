<?php

namespace App\Models\Discount;

use App\Models\Catalog\Product;
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
