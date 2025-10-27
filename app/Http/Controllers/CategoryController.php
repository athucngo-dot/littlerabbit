<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * get the list of categories that have 2 or more active products
     */
    public function browseCategoriesPage()
    {
        // get categories that have 2 or more active products
        $categoryList = Category::whereHas('products', function ($query) {
                                            $query->where('is_active', true);
                                        }, '>=', 2)
                                        ->orderBy('name')
                                        ->get();

        return view('categories.browse-categories', compact('categoryList'));
    }
}
