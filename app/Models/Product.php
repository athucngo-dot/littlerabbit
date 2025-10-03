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

    /**
     * The deals that has highest discount for the product at that time
     */
    public function bestDeal()
    {
        return $this->deals()
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->orderByDesc('percentage_off')
            ->limit(1);
    }

    /**
     * get the related products
     * where they are in same category or brand
     */
    public function getRelatedProducts($limit = null)
    {
        //if limit is null, set to default value
        $limit ??= config('site.max_related_product');

        // get the list of product that are not current product
        // and have the same categories or same brand
        // random order
        // and with set limit
        return Product::whereKeyNot($this->id)
            ->when($this->category_id, 
                    fn($q) => $q->where('category_id', $this->category_id)
            )
            ->orWhere(fn($q) => $q->where('brand_id', $this->brand_id))
            ->with('images')
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    /**
     * get price of the product after applying discount
     * if the discount percentage is not passed, 
     * it will get the higest discount related to the product
     */
    public function getPriceAfterDeal($percentage_off=null)
    {
        if ($percentage_off) {
            return $this->price * (100 - $percentage_off) / 100;
        } else {
            $applyDeal = $this->bestDeal()->first();
            return $this->price * (100 - $applyDeal->percentage_off) / 100;
        }
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
