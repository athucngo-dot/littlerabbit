<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Color;  
use App\Models\Category;
use App\Models\Size;
use App\Models\Material;

class FilterService
{
    /**
     * Get available filter options for products.
     */
    public static function getFilterOptions()
    {
        $brands = Brand::orderBy('name')->pluck('name', 'id');
        $colors = Color::orderBy('name')->pluck('name', 'id');
        $categories = Category::orderBy('name')->pluck('name', 'id');
        $sizes = Size::orderBy('id')->pluck('size', 'id');
        $materials = Material::orderBy('name')->pluck('name', 'id');

        return compact('brands', 'colors', 'categories', 'sizes', 'materials');
    }
}
