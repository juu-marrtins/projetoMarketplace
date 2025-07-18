<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'description',
        'startDate',
        'endDate',
        'discountPercentage',
        'productId'
    ];
    
    public function product(){
        return $this->belongsTo(Product::class, 'productId'); 
    }
}
