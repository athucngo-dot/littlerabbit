<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            /* Only set slug when creating (not updating)
               If update a category name later, slug does not change
                to avoid breaking existing links (better for SEO)
            */

            if (empty($category->slug)) {
                $slug = Str::slug($category->name);
                $count = Category::where('slug', 'LIKE', "{$slug}%")->count();

                $category->slug = $count ? "{$slug}-{$count}" : $slug;
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug'; // use slug for route model binding
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
