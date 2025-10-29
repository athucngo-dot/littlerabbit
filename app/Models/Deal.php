<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Deal extends Model
{
    protected $table = 'deals';

    protected $fillable = [
        'name',
        'slug',
        'percentage_off',
        'start_date',
        'end_date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($deal) {
            /* Only set slug when creating (not updating)
               If update a deal name later, slug does not change
                to avoid breaking existing links (better for SEO)
            */

            if (empty($deal->slug)) {
                $slug = Str::slug($deal->name);
                $count = Deal::where('slug', 'LIKE', "{$slug}%")->count();

                $deal->slug = $count ? "{$slug}-{$count}" : $slug;
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug'; // use slug for route model binding
    }

    /**
     * The deals that belong to the product.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
