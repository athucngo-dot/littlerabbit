<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\RecentlyViewed;
use App\Services\RecentlyViewedService;

class ProductService
{
    /**
     * Get product details by slug, 
     * including related relationships and calculated fields.
     */
    public static function getProductDetails(string $slug): Product
    {
        // query to load the product by slug and eager load related relationships used in the view
        $productQr = Product::with([
                'images' => function ($query) {
                    $query->orderByDesc('is_primary'); // primary comes first
                },
                'deals' => function ($query) {
                    $query->orderByDesc('percentage_off'); // best deal comes on top
                },
                'brand', 
                'colors',
                'sizes',
                'material',
                'reviews.customer' // eager load review->customer to show name
            ])
            ->where('slug', $slug)
            ->isActive();

        // Fetches the product from cache first
        // if not, then hit the DB
        $product = Cache::remember(
            "product_{$slug}_show", // cache key
            config('site.cache_time_out'),
            function() use ($productQr) {
                return $productQr->firstOrFail();
            }
        );

        // Make sure features is an array
        $features = $product->features;
        // Fallback in case it's still a JSON string
        if (is_string($features)) {
            $product->features = json_decode($features, true) ?? [];
        }

        // apply best deal to the price
        $product->price_after_deals = $product->getPriceAfterDeal($product->deals->isNotEmpty() ? $product->deals[0]->percentage_off : null);

        // limit max purchasable to 10 or available stock, whichever is lower
        $product->max_quantity = min($product->stock,  config('site.cart.max_quantity')); 

        return $product;
    }

    /**
     * Build a product list query with optional filters and scope.
     * This can be used for different product listing endpoints.
     */
    public static function buildProductListQuery(Request $request, ?string $scope = null)
    {
        $gender     = $request->query('gender');
        $brandId    = $request->query('brand');
        $sizeId     = $request->query('size');
        $materialId = $request->query('material');
        $categoryId = empty($request->query('category')) ? [] : [$request->query('category')];
        $colorId    = $request->query('color');
        $discount   = $request->query('discount');

        if ($scope === 'deals' && empty($discount)) {
            $discount = 'all'; // for deals page, default to show all with discount
        }

        $query = Product::with(['colors', 'brand', 'category', 'sizes', 'deals'])
            ->isActive()
            ->hasGender($gender)
            ->hasBrand($brandId)
            ->hasSize($sizeId)
            ->hasColor($colorId)
            ->hasMaterial($materialId)
            ->hasCategory($categoryId)
            ->hasDiscountRange($discount);

        // Apply scope-specific filters
        if ($scope === 'newArrivals') {
            $query->newArrivals();
        }

        return $query;
    }

    /**
     * Transform a Product model into a structured array for API response.
     */
    public static function transformProduct($product)
    {
        $dealsList = $product->deals->isNotEmpty()
            ? $product->deals->map(fn($deal) => [
                'name' => $deal->name,
                'percentage_off' => $deal->percentage_off,
            ])->values()
            : [];

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => $product->price,
            'image' => $product->images()->primary()->url ?? config('site.default_product_image'),
            'gender' => $product->gender,
            'colors' => $product->colors->pluck('name'),
            'brand' => $product->brand?->name,
            'category' => $product->category?->name,
            'sizes' => $product->sizes->pluck('size'),
            'deals' => $dealsList,
            'discount' => $product->deals->max('percentage_off') ?? 0,
            'price_after_deals' => $product->getPriceAfterDeal(),
        ];
    }

    /**
     * Store a recently viewed product for the current user or guest.
     */
    public static function storeRecentlyViewedProduct($product)
    {
        if (Auth::check()) {
            // For logged in user, store in DB

            $customerId = Auth::id();
            $conditions['customer_id'] = $customerId;
            $conditions['product_id']  = $product->id;

            $rViewed = RecentlyViewed::updateOrCreate($conditions, ['viewed_at' => now()]);

            if ($rViewed->wasRecentlyCreated) {
                // Keep only latest max_recently_viewed_stored records, delete older ones
                RecentlyViewedService::trimOldViews($customerId);
            }
        } else {
            // For guest user, store in session

            $recentlyViewed = session()->get(config('site.recently_viewed_session_key'), []);
            $productId = $product->id;

            // Remove if it already exists (to reinsert it on top)
            $recentlyViewed = array_filter($recentlyViewed, function ($item) use ($productId) {
                return $item['id'] !== $productId;
            });

            // Add new record at the beginning
            array_unshift($recentlyViewed, [
                'id' => $productId,
                'viewed_at' => now()->toDateTimeString(),
            ]);

            // Keep only the latest max_recently_viewed_stored records
            $recentlyViewed = array_slice($recentlyViewed, 0, config('site.max_recently_viewed_stored'));

            // Save back to session
            session([config('site.recently_viewed_session_key') => array_values($recentlyViewed)]);
        }
    }

    /**
     * Retrieve recently viewed products for the current user or guest.
     */
    public static function retrieveRecentlyViewedProduct(?int $excludeProductId = null)
    {
        if (Auth::check()) {
            // For logged in user, retrieve recently viewed from DB
            $customer = Auth::user();
            return $customer->recentlyViewedProducts()
                    ->where('products.is_active', true)
                    ->when($excludeProductId, fn($q) =>
                        $q->where('products.id', '!=', $excludeProductId)
                    )
                    ->limit(config('site.max_related_product'))
                    ->get()
                    ;
        } else {
            // For guest user, retrieve recently viewed from session
            $recentlyViewed = session()->get(config('site.recently_viewed_session_key'), []);
            
            if (empty($recentlyViewed)) {
                return collect(); // return empty collection if no recently viewed products
            }

            $productIdList = array_column($recentlyViewed, 'id');

            return Product::whereIn('id', $productIdList)
                        ->where('is_active', true)
                        ->when($excludeProductId, fn($q) =>
                            $q->where('id', '!=', $excludeProductId)
                        )
                        ->orderByRaw('FIELD(id, ' . implode(',', $productIdList) . ')') // maintain order from the session
                        ->limit(config('site.max_related_product'))
                        ->get();
        }
    }

    public static function addOrUpdateRecentlyViewedToDB()
    {
        //get recently viewed from session
        $recentlyViewed = session()->get(config('site.recently_viewed_session_key'), []);

        //log::info('Merging recently viewed products from session to DB', ['data' => $recentlyViewed]);
        if (empty($recentlyViewed)) {
            return; // nothing to merge
        }

        $customerId = Auth::id();
        foreach ($recentlyViewed as $item) {
            $conditions['customer_id'] = $customerId;
            $conditions['product_id']  = $item['id'];

            // update or create record
            RecentlyViewed::updateOrCreate($conditions, ['viewed_at' => $item['viewed_at']]);
        }

        // Keep only latest max_recently_viewed_stored records, delete older ones
        RecentlyViewedService::trimOldViews($customerId);

        // Clear the session data
        session()->forget(config('site.recently_viewed_session_key'));
    }
}
