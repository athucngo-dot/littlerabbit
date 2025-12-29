<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

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

    public function getImgUrl()
    {
        return str_starts_with($this->url, 'https://placehold.co') ?
            $this->url : Storage::url($this->url);
    }

    /**
     * Scope a query to only include the primary image.
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true)->first();
    }
}
