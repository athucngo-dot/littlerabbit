<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = [
        'customer_id',
        'type',
        'street',
        'city',
        'province',
        'postal_code',
        'country',
        'is_default',
        'is_active'
    ];
}
