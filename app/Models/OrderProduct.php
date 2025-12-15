<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_product';

    protected $fillable = [
        'order_id',
        'product_id',
        'color_id',
        'size_id',
        'nb_of_items',
        'org_price',
        'percentage_off',
        'price',
        'quantity',
        'options',
    ];
}
