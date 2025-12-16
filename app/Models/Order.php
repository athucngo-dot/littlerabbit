<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Models\OrderAddresses;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'order_number',
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

    /**
     * Use order_number for route model binding
     */
    public function getRouteKeyName()
    {
        return 'order_number';
    }

    /**
     * Relationships
     */
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

    public function addresses()
    {
        return $this->hasMany(OrderAddresses::class, 'order_id');
    }
}
