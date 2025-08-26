<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'customer_id',
        'order_id',
        'provider',
        'provider_transaction_id',
        'provider_customer_id',
        'card_brand',
        'card_last_four',
        'card_exp_month',
        'card_exp_year',
        'amount',
        'currency',
        'status',
        'paid_at',
    ];
}
