<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    
    protected $table = 'reviews';

    protected $fillable = [
        'product_id',
        'customer_id',
        'rv_rate',
        'rv_comment',
        'rv_quality',
        'rv_comfort',
        'rv_size',
        'rv_delivery',
    ];

    /**
     * The product this review belongs to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class); 
    }

    /**
     * The customer who wrote this review.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);   
    }
}
