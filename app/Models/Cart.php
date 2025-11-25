<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = [
        'customer_id',
        'product_id',
        'color_id',
        'size_id',
        'quantity',
        'options',  
    ];

    /**
     * Get the product associated with the cart item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class)
                    ->where('is_active', true); 
    }

    /**
     * Get the color associated with the cart item.
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Get the size associated with the cart item.
     */
    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
