<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CmsProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Services\ProductService;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Material;
use App\Models\Color;
use App\Models\Size;
use App\Models\Deal;

class CmsProductController extends Controller
{
    /**
     * Display a listing of products for CMS.
     */
    public function list()
    {
        $products = Product::orderBy('id')
                    ->paginate(config('site.cms_items_per_page'));
        
        return view('cms.products.list', compact('products'));
    }

    /**
     * Edit product
     */
    public function edit(Product $product)
    {
        $product = $product->load(['colors', 'sizes', 'deals', 'images']);
        
        // Make sure features is an array
        $features = $product->features;
        // Fallback in case it's still a JSON string
        if (is_string($features)) {
            $product->features = json_decode($features, true) ?? [];
        }
        
        $genders = [
            ['id'=>'boy', 'name' =>'Boy'],
            ['id'=>'girl', 'name' =>'Girl'],
            ['id'=>'unisex', 'name' =>'Unisex']
        ];

        $brands = Brand::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $materials = Material::orderBy('name')->get();
        $colors = Color::orderBy('name')->get();
        $sizes = Size::all();
        $deals = Deal::orderBy('name')->get();

        $allowEdit = in_array(Auth::guard('admin')->user()->role, ['super_admin', 'admin', 'editor']) ? true : false;
        return view('cms.products.edit', 
            compact('product', 'genders', 'brands', 'categories', 'materials',
                    'colors', 'sizes', 'deals', 'allowEdit'));
    }

    /**
     * Action update product
     */
    public function update(CmsProductRequest $request, Product $product)
    { 
        $productData = $request->only([
            'name', 'slug', 'price', 'stock', 'nb_of_items',
            'description', 'features', 'gender', 'brand_id',
            'category_id', 'material_id', 'is_active',
            'new_arrival', 'homepage_promo'
        ]);

        // JSON encode features
        $features = collect(
                preg_split('/\r\n|\r|\n/', trim($productData['features']))
            )
            ->filter()
            ->values()
            ->toArray();

        $productData['features'] = json_encode($features);

        // If checkbox is unchecked, set default to false
        $productData['is_active'] = $request->has('is_active');
        $productData['new_arrival'] = $request->has('new_arrival');

        $product->update($productData);

        $product->colors()->sync($request->colors ?? []);
        $product->sizes()->sync($request->sizes ?? []);
        $product->deals()->sync($request->deals ?? []);

        // handle image upload
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $index => $file) {
                $path = $file->store("products/{$product->id}", 'public');

                $product->images()->create([
                    'url' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        // Remove images
        if ($request->filled('remove_images')) {
            $images = $product->images()->whereIn('id', $request->remove_images)->get();

            foreach ($images as $image) {
                Storage::disk('public')->delete($image->url);
                $image->delete();
            }
        }

        // Set primary image
        if ($request->filled('primary_image')) {
            $product->images()->update(['is_primary' => false]);

            $product->images()
                ->where('id', $request->primary_image)
                ->update(['is_primary' => true]);
        }

        return redirect()
            ->route('cms.products.edit', $product)
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Search products by slug
     */
    public function search(Request $request)
    {
        $search = array('-', ' ');
        $replace = array('%', '%');
        $slug = str_replace($search, $replace, $request->slug);
        
        // add slash for '_' and '\' for SQL
        $escapedSlug = addcslashes($slug, "_\\"); 

        $products = Product::slugLike($escapedSlug)
                    ->latest('created_at')
                    ->paginate(config('site.cms_items_per_page'));
        
        return view('cms.products.list', compact('products'));
    }
}
