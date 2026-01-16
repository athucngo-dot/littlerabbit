<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class OrderAddresses extends Model
{
    protected $table = 'order_addresses';

    protected $fillable = [
        'order_id',
        'first_name',
        'last_name',
        'type',
        'street',
        'city',
        'province',
        'postal_code',
        'country',
        'phone_number',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /** 
     * Get the full name of the address.
     */
    public function getFullNameAttribute()
    {
        return ucwords("{$this->first_name} {$this->last_name}");
    }

    /** 
     * Get the full address line.
     */
    public function getAddressLineAttribute()
    {
        return "{$this->street}, {$this->city}, {$this->province} {$this->postal_code}, {$this->country}";
    }
}
