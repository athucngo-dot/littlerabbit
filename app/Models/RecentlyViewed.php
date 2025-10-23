<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecentlyViewed extends Model
{
    protected $table = 'recently_viewed';

    protected $fillable = ['customer_id', 'product_id', 'viewed_at'];

    /**
     * The customer who viewed the product.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * The product that was viewed.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
