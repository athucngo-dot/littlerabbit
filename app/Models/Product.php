<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'img_url',
        'gender',
        'is_active',
        'new_arrival',
        'continue',
        'color_id',
        'brand_id',
        'material_id',
        'category_id',
    ];

    /**
     * The color this product belongs to.
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * The brand this product belongs to.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * The material this product belongs to.
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * The category this product belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class)
                    ->withPivot('child_cat', 'size');
    }

    public function seasons()
    {
        return $this->belongsToMany(Season::class)
                    ->withPivot('name');
    }

    public function reviews()
    {
        return $this->belongsToMany(Customer::class, 'reviews', 'product_id', 'customer_id')
                    ->withPivot('rv_rate', 'rv_comment', 'rv_quality', 'rv_comfort', 'rv_size', 'rv_delivery')
                    ->withTimestamps();
    }

    public function deals()
    {
        return $this->belongsToMany(Deal::class)
                    ->withPivot('discount_percentage', 'start_date', 'end_date');
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_active', true)->where('stock', '>', 0);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeNewArrivals($query)
    {
        return $query->where('new_arrival', true);
    }
}
