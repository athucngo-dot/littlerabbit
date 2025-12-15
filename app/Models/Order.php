<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'status',
        'stripe_payment_intent_id',
        'subtotal',
        'shipping',
        'total',
        'shipping_type',
        'paid_at',
        'failed_at',
        'options',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')
                    ->withPivot('numb_items', 'price','quantity')
                    ->withTimestamps();
    }
}
