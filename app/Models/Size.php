<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Size extends Model
{
    protected $table = 'sizes';

    protected $fillable = [
        'child_cat',
        'size',
    ];
}
