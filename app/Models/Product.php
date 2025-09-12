<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'features',
        'price',
        'stock',
        'gender',
        'is_active',
        'new_arrival',
        'continue',
        'brand_id',
        'material_id',
        'category_id',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            /* Only set slug when creating (not updating)
               If update a product’s name later, slug does not change
                to avoid breaking existing links (better for SEO)
            */

            if (empty($product->slug)) {
                $slug = Str::slug($product->name);
                $count = Product::where('slug', 'LIKE', "{$slug}%")->count();

                $product->slug = $count ? "{$slug}-{$count}" : $slug;
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug'; // use slug for route model binding
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'product_id');
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

    /**
     * The sizes that belong to the product.
     */
    public function sizes()
    {
        return $this->belongsToMany(Size::class);
    }

    /**
     * The color this product belongs to.
     */
    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    /**
     * The seasons that belong to the product.
     */
    public function seasons()
    {
        return $this->belongsToMany(Season::class)
                    ->withPivot('name');
    }

    /**
     * The customers that have reviewed the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * The deals that belong to the product.
     */
    public function deals()
    {
        return $this->belongsToMany(Deal::class);
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
