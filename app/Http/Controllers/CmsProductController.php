<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Models\Product;

class CmsProductController extends Controller
{
    /**
     * Display a listing of products for CMS.
     */
    public function productList()
    {
        $products = Product::latest('created_at')
                    ->paginate(config('site.cms_items_per_page'));
        
        return view('cms.products.list', compact('products'));
    }

    public function productEdit()
    {

    }
}
