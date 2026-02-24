<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebhookEvent extends Model
{
    use HasFactory;
    
    protected $table = 'webhook_events';

    protected $fillable = [
        'stripe_event_id',
        'type',
    ];
}
