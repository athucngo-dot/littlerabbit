<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    protected $table = 'brands';

    protected $fillable = [
        'name',
    ];
}
