<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = [
        'customer_id',
        'session_id',
        'product_id',
        'color_id',
        'size_id',
        'quantity',
        'options',  
    ];
}
