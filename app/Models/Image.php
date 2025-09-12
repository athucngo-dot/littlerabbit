<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;
    
    protected $table = 'images';

    protected $fillable = [
        'product_id',
        'url',
        'is_primary',
    ];

    /**
     * Get the product that owns the image.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope a query to only include the primary image.
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true)->first();
    }
}
