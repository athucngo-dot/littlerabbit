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
        dd('CMS Product List');exit;
        return view('products.new-arrivals', compact('brands', 'colors', 'categories', 'sizes', 'materials'));
    }
}
