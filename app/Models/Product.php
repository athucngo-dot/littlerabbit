<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

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
        'homepage_show',
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

    public function cachedReviews()
    {
        return Cache::remember(
            "product_{$this->id}_reviews",  // cache key
            config('site.cache_time_out'), // cache time in seconds
            function () {
                return $this->reviews()->with('customer')->get();
            }
        );
    }

    /**
     * The deals that belong to the product.
     */
    public function deals()
    {
        return $this->belongsToMany(Deal::class)
                    ->orderByDesc('percentage_off');
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

        // query to get the list of product that are not current product
        // and have the same categories or same brand
        // random order
        // and with set limit
        $query = Product::where('is_active', true)
            ->whereKeyNot($this->id)
            ->where(function($q) {
                if ($this->category_id) {
                    $q->where('category_id', $this->category_id);
                }
                if ($this->brand_id) {
                    $q->orWhere('brand_id', $this->brand_id);
                }
            })
            ->with('images')
            ->inRandomOrder()
            ->limit($limit);

        // Fetches list from cache first
        // if not, then hit the DB
        return Cache::remember(
            "product_{$this->id}_related", // cache key
            config('site.cache_time_out'),
            function() use ($query) {
                return $query->get();
            }
        );
    }

    /**
     * get price of the product after applying discount
     * if the discount percentage is not passed, 
     * it will get the higest discount related to the product
     */
    public function getPriceAfterDeal($percentage_off=null)
    {
        if (!empty($percentage_off)) {
            return $this->price * (100 - $percentage_off) / 100;
        } else {
            $applyDeal = $this->bestDeal()->first();
            
            if (!$applyDeal) {
                return $this->price; // no deal, return original price
            }

            return $this->price * (100 - $applyDeal->percentage_off) / 100;
        }
    }

    /**
     * add to query is_active = true
     */
    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * add to query stock > 0
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * add to query is_active = true and stock is more than 0
     */
    public function scopeAvailable($query)
    {
        return $query->isActive()->inStock();
    }

    /**
     * add to query new_arrival = true
     */
    public function scopeNewArrivals($query)
    {
        return $query->where('new_arrival', true);
    }

    /**
     * add to query to filter by gender.
     */
    public function scopeHasGender($query, $gender = null)
    {
        if (!empty($gender) && 
            in_array($gender, ['boy', 'girl', 'unisex'])) {
            return $query->where('gender', $gender);
        }

        return $query;
    }

    /**
     * add to query to filter by size_id
     */
    public function scopeHasSize($query, $sizeId = null)
    {
        if (!empty($sizeId)) {
            $query->whereExists(function ($q) use ($sizeId) {
                $q->select(DB::raw(1))
                    ->from('product_size')
                    ->whereColumn('product_size.product_id', 'products.id')
                    ->where('product_size.size_id', $sizeId);
            });
        }

        return $query;
    }

    /**
     * add to query to filter by age group
     */
    public function scopeHasAgeGroup($query, $ageGroup = null)
    {
        if (!empty($ageGroup)) {
            return $query->whereHas('sizes', function ($q) use ($ageGroup) {
                $q->where('child_cat', $ageGroup);
            });
        }

        return $query;
    }

    /**
     * add to query to filter by color_id
     */
    public function scopeHasColor($query, $colorId = null)
    {
        if (!empty($colorId)){
            $query->whereExists(function ($q) use ($colorId) {
                $q->select(DB::raw(1))
                    ->from('color_product')
                    ->whereColumn('color_product.product_id', 'products.id')
                    ->where('color_product.color_id', $colorId);
            });
        }

        return $query;
    }

    /**
     * add to query to filter by discount
     */
    public function scopeHasDiscount($query, $discount = null)
    {
        if (is_null($discount)) {
            return $query;
        }

        if ($discount === 'all') {
            // any discount
            $query->whereHas('deals', function ($q) {
                $q->where('percentage_off', '>', 0)
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now());
            });

            return $query;
        }

        // Define discount ranges
        $ranges = [
            '25'       => [1, 25],
            '25-50'    => [25, 50],
            '50-75'    => [50, 75],
            'clearance'=> [75, 100],
        ];

        // Apply matching condition
        if (array_key_exists($discount, $ranges)) {
            [$min, $max] = $ranges[$discount]; // get min and max from the range
            
            $query->whereHas('deals', function ($q) use ($discount, $min, $max){
                $q->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now());

                if ($discount === 'clearance') {
                    $q->where('percentage_off', '>=', $min);
                } else {
                    $q->whereBetween('percentage_off', [$min, $max]);
                }

            });
        }

        return $query;
    }

    /**
     * add to query to filter by brand_id.
     */
    public function scopeHasBrand($query, $brandId = null)
    {
        if (!empty($brandId)) {
            return $query->where('brand_id', $brandId);
        }

        return $query;
    }

    /**
     * add to query to filter by material_id.
     */
    public function scopeHasMaterial($query, $materialId = null)
    {
        if (!empty($materialId)) {
            return $query->where('material_id', $materialId);
        }
        
        return $query;
    }

    /**
     * add to query to filter by array category_id.
     */
    public function scopeHasCategory($query, array $categoryIds = [])
    {
        if (!empty($categoryIds)) {
            return $query->whereIn('category_id', $categoryIds);
        }
        
        return $query;
    }
}
