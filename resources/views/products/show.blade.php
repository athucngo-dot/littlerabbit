@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-mint to-paper-2">
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        {{-- Product Main Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- Left: Images Carousel with Thumbnails --}}
                <div 
                    x-data='imageCarousel(@json($product->images->pluck("url")->toArray()))'
                    x-init=""
                    tabindex="0"
                    @keydown.window="keydown($event)"
                    class="relative space-y-4"
                >
                    {{-- Main Image --}}
                    <div class="relative">
                        <img 
                            :src="currentImage" 
                            alt="Product Image" 
                            class="w-full h-auto rounded-2xl shadow-md"
                            @touchstart="touchStart($event)" 
                            @touchend="touchEnd($event)"
                        >

                        {{-- Prev Button --}}
                        <button @click="prev" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow">
                            ‹
                        </button>

                        {{-- Next Button --}}
                        <button @click="next" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow">
                            ›
                        </button>

                        {{-- Zoom Button --}}
                        <button @click="zoom = true" class="absolute top-2 right-2 bg-white p-2 rounded-full shadow">
                            🔍
                        </button>
                    </div>

                    {{-- Thumbnails --}}
                    <div class="flex space-x-2 justify-center">
                        <template x-for="(img, index) in images" :key="index">
                            <img 
                                :src="img" 
                                @click="current = index" 
                                class="w-16 h-16 object-cover rounded-md border cursor-pointer"
                                :class="{'border-blue-500': current === index}"
                            >
                        </template>
                    </div>

                    {{-- Zoom Modal --}}
                    <div 
                        x-show="zoom" 
                        class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50"
                        @click.self="zoom = false"
                    >
                        <img :src="currentImage" class="max-w-3xl max-h-[90vh] rounded-xl shadow-lg">
                        <button @click="zoom = false" class="absolute top-4 right-4 text-white text-3xl">✕</button>
                    </div>
                </div>

                {{-- Right: Product Info --}}
                <div class="space-y-6">
                    <p class="text-lg text-gray-600">{{ stripslashes($product->brand?->name) }}</p>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>

                    {{-- Average rating and review count --}}
                    <div x-data="reviewsManager('{{ $product->slug }}')" x-init="init()" class="flex items-center space-x-2 mt-2">
                        <div class="flex space-x-0.5">
                            <template x-for="i in 5" :key="i">
                                <svg class="w-5 h-5" viewBox="0 0 20 20">
                                    <defs>
                                        <linearGradient :id="'half-grad-' + i" x1="0" y1="0" x2="100%" y2="0">
                                            <stop offset="50%" stop-color="gold" />
                                            <stop offset="50%" stop-color="lightgray" />
                                        </linearGradient>
                                    </defs>
                                    <path :fill="i <= Math.floor(averageRate) ? 'gold' 
                                                    : (i === Math.ceil(averageRate) && averageRate % 1 !== 0 ? 'url(#half-grad-' + i + ')' 
                                                    : 'lightgray')"
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.286 3.955c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.176 0l-3.37 2.448c-.784.57-1.838-.197-1.539-1.118l1.285-3.955a1 1 0 00-.364-1.118L2.063 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.951-.69l1.285-3.955z"/>
                                </svg>
                            </template>
                        </div>
                        <span class="text-gray-600 text-sm" x-text="reviews.length + ' reviews'"></span>
                    </div>

                    {{-- Colors --}}
                    <div id="colorOptions" class="flex items-center space-x-4">
                        <span class="font-bold text-gray-800">Colors:</span>
                        @foreach ($product->colors as $color)
                            <button type="button" class="flex flex-col items-center text-center p-1 focus:ring-2 focus:ring-aqua transition"
                                    data-color-id="{{ $color->id }}">
                                <span class="w-6 h-6 rounded-full border" style="background-color: {{ $color->hex ?? '#000' }}"></span>
                                <span class="text-sm mt-1">{{ $color->name }}</span>
                            </button>
                        @endforeach
                        <input type="hidden" id="color" name="color_id">
                    </div>

                    {{-- Sizes --}}
                    <div id="sizeOptions" class="flex items-center space-x-2">
                        <span class="font-bold text-gray-800">Sizes:</span>
                        @foreach ($product->sizes as $size)
                            <button type="button" class="px-2 py-1 border rounded"
                                    data-size-id="{{ $size->id }}">
                                {{ $size->size }}
                            </button>
                        @endforeach
                        <input type="hidden" id="size" name="size_id">
                    </div>

                    {{-- Price --}}
                    {{-- Note: only apply the highest discount --}}
                    @if ($priceAfterDeal != $product->price)
                        <p>
                            <span class="text-xl text-red-500">-{{ number_format($product->bestDeal[0]->percentage_off) }}% </span>
                            <span class="text-2xl font-bold text-gray-900 px-2">${{ number_format($priceAfterDeal, 2) }}</span>
                        </p>
                        <p class="text-sm text-gray-900">Was: <span class="line-through px-2">${{ number_format($product->price, 2) }}</span></p>
                        @if ($product->deals->isNotEmpty())
                            <p class="text-sm text-gray-900">Eligible for the following discount(s):
                            @foreach ($product->deals as $deal)
                                {{ $deal->name }} (<span class="text-red-400">-{{ $deal->percentage_off }}</span>) | </li>
                            @endforeach
                            </p>
                        @endif
                    @else
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</p>
                    @endif

                    {{-- Shipping --}}
                    <p class="text-gray-600 text-sm">Shipping within 24 hours of your orders</p>

                    {{-- Stock Status --}}
                    @if (intval($product->stock) > 0)
                        <p class="text-green-600 font-semibold">In Stock</p>
                        
                        {{-- Quantity Selector --}}
                        <span class="font-bold text-gray-800">Quantity:</span>
                        <select name="quantity" id="quantity" class="text-sm mt-1 px-2 py-1 border">
                            @for ($i = 1; $i <= $maxQuantity; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        {{-- Add to Cart --}}
                        <button type="button" id="addToCartBtn" data-product-slug="{{ $product->slug }}"
                                class="bg-aqua hover:bg-aqua-2 text-white px-6 py-3 rounded-lg font-semibold w-full mx-auto block">
                            Add to Cart
                        </button>
                    @else
                        <p class="text-red-600 font-semibold">Out of Stock</p>
                    @endif

                    {{-- Description --}}
                    <h4 class="font-bold text-gray-800">Details</h4>
                    <p class="text-gray-700">{{ $product->description }}</p>

                    {{-- Features --}}
                    @if (!empty($features) || !empty($product->material))
                        <h4 class="font-bold text-gray-800 mb-2">Features</h4>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            @if (!empty($features))
                                @foreach ($features as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            @endif
                            @if (!empty($product->material))
                                <li>Material: {{ $product->material?->name }}</li>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>

            {{-- Related Products Carousel --}}
            <div class="mt-16">
                <h2 class="text-2xl font-bold mb-6">You may also like</h2>
                <div x-data="carousel(@js($relatedProducts->map(fn($p) => [
                            'id' => $p->id,
                            'slug' => $p->slug,
                            'name' => $p->name,
                            'url' => optional($p->images->first())->url ?? 'https://via.placeholder.com/300',
                            'price' => $p->price
                        ])->values()->toArray()))" class="relative">

                    {{-- Left Arrow --}}
                    <button @click="prev" class="absolute left-0 top-1/2 -translate-y-1/2 bg-white rounded-full shadow p-2">&lt;</button>

                    {{-- Items --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 overflow-hidden">
                        <template x-for="item in visibleItems" :key="item.id">
                            <a :href="`/products/${item.slug}`" class="block bg-white rounded-xl shadow hover:shadow-lg overflow-hidden">
                                <img :src="item.url" :alt="item.name" class="w-full h-48 object-cover">
                                <div class="p-4 text-center">
                                    <h3 class="font-semibold text-lg" x-text="item.name"></h3>
                                    <p class="text-gray-600">$<span x-text="Number(item.price).toFixed(2)"></span></p>
                                </div>
                            </a>
                        </template>
                    </div>

                    {{-- Right Arrow --}}
                    <button @click="next" class="absolute right-0 top-1/2 -translate-y-1/2 bg-white rounded-full shadow p-2">&gt;</button>
                </div>
            </div>

            {{-- Frequently Purchased Carousel --}}
            <div class="mt-16">
                <h2 class="text-2xl font-bold mb-6">Frequently Purchased Together</h2>
                <div x-data="carousel(@js($frequentlyPurchased->map(fn($p) => [
                            'id' => $p->id,
                            'slug' => $p->slug,
                            'name' => $p->name,
                            'url' => optional($p->images->first())->url ?? 'https://via.placeholder.com/300',
                            'price' => $p->price
                        ])->values()->toArray()))" class="relative">

                    {{-- Left Arrow --}}
                    <button @click="prev" class="absolute left-0 top-1/2 -translate-y-1/2 bg-white rounded-full shadow p-2">&lt;</button>

                    {{-- Items --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 overflow-hidden">
                        <template x-for="item in visibleItems" :key="item.id">
                            <a :href="`/products/${item.slug}`" class="block bg-white rounded-xl shadow hover:shadow-lg overflow-hidden">
                                <img :src="item.url" :alt="item.name" class="w-full h-48 object-cover">
                                <div class="p-4 text-center">
                                    <h3 class="font-semibold text-lg" x-text="item.name"></h3>
                                    <p class="text-gray-600">$<span x-text="Number(item.price).toFixed(2)"></span></p>
                                </div>
                            </a>
                        </template>
                    </div>

                    {{-- Right Arrow --}}
                    <button @click="next" class="absolute right-0 top-1/2 -translate-y-1/2 bg-white rounded-full shadow p-2">&gt;</button>
                </div>
            </div>

            {{-- Reviews Section --}}
            <div x-data="reviewsManager(@js($product->slug))" x-init="init()" class="space-y-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold">Customer Reviews</h2>
                </div>

                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Left Column: 1/4 -->
                    <div class="w-full lg:w-1/4 bg-white p-4 rounded shadow space-y-4">
                        <!-- Average Rating -->
                        <div class="text-center">
                            <div class="flex justify-center space-x-1 mb-2">
                                <template x-for="i in 5" :key="i">
                                    <svg class="w-5 h-5" viewBox="0 0 20 20">
                                        <defs>
                                            <linearGradient :id="'half-grad-' + i" x1="0" y1="0" x2="100%" y2="0">
                                                <stop offset="50%" stop-color="gold" />
                                                <stop offset="50%" stop-color="lightgray" />
                                            </linearGradient>
                                        </defs>
                                        <path :fill="i <= Math.floor(averageRate) ? 'gold' 
                                                        : (i === Math.ceil(averageRate) && averageRate % 1 !== 0 ? 'url(#half-grad-' + i + ')' 
                                                        : 'lightgray')"
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.286 3.955c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.176 0l-3.37 2.448c-.784.57-1.838-.197-1.539-1.118l1.285-3.955a1 1 0 00-.364-1.118L2.063 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.951-.69l1.285-3.955z"/>
                                    </svg>
                                </template>
                            </div>
                            <div class="text-lg font-bold" x-text="averageRate.toFixed(1) + ' out of 5'"></div>
                            <div class="text-gray-600 text-sm" x-text="reviews.length + ' ratings'"></div>
                        </div>

                        <!-- Rating Chart -->
                        <div class="space-y-1">
                            <template x-for="rate in [5,4,3,2,1]" :key="rate">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm w-4" x-text="rate"></span>
                                    <div class="flex-1 h-3 bg-gray-200 rounded overflow-hidden">
                                        <div class="h-full" 
                                            :class="reviews.length > 0 ? 'bg-yellow-400' : 'bg-gray-300'"  
                                            :style="'width: ' + ((reviews.filter(r => r.rv_rate == rate).length / reviews.length) * 100) + '%'">
                                        </div>
                                    </div>
                                    <span class="text-sm w-6 text-right" x-text="reviews.filter(r => r.rv_rate == rate).length"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Right Column: 3/4 -->
                    <div class="w-full lg:w-3/4 space-y-4">
                        <template x-for="review in displayedReviews" :key="review.id">
                            <div class="bg-white p-4 rounded shadow">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-semibold" x-text="review.customer_name"></span>
                                    <div class="flex space-x-0.5">
                                        <template x-for="i in 5" :key="i">
                                            <svg class="w-4 h-4" fill="currentColor" :class="{
                                                'text-yellow-400': i <= review.rv_rate,
                                                'text-gray-300': i > review.rv_rate
                                            }" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.286 3.955c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.176 0l-3.37 2.448c-.784.57-1.838-.197-1.539-1.118l1.285-3.955a1 1 0 00-.364-1.118L2.063 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.951-.69l1.285-3.955z"/>
                                            </svg>
                                        </template>
                                    </div>
                                </div>
                                <p class="text-gray-700" x-text="review.rv_comment"></p>
                            </div>
                        </template>

                        <button x-show="moreReviews.length > 0" @click="loadMore()" class="bg-aqua hover:bg-aqua-2 text-white px-4 py-2 rounded-lg">
                            Load More Reviews
                        </button>
                    </div>
                </div>
            </div>


        </div>
    </div>
    
    <!-- Popup here -->
    <x-popup />
</section>

{{-- Alpine.js --}}
<script>
function imageCarousel(urls) {
    return {
        images: urls.length ? urls : ['https://placehold.co/600x600?text=No+Image'],
        current: 0,
        zoom: false,
        startX: 0,
        endX: 0,

        get currentImage() { return this.images[this.current]; },

        prev() { this.current = (this.current === 0) ? this.images.length - 1 : this.current - 1; },
        next() { this.current = (this.current === this.images.length - 1) ? 0 : this.current + 1; },

        touchStart(e) { this.startX = e.touches[0].clientX; },
        touchEnd(e) {
            this.endX = e.changedTouches[0].clientX;
            const diff = this.startX - this.endX;
            if (diff > 50) this.next();
            if (diff < -50) this.prev();
        },

        keydown(e) {
            if (e.key === 'ArrowLeft') this.prev();
            if (e.key === 'ArrowRight') this.next();
            if (e.key === 'Escape') this.zoom = false;
        }
    }
}

function carousel(items) {
    return {
        items: items,
        start: 0,
        perPage: 5,
        get visibleItems() { return this.items.slice(this.start, this.start + this.perPage); },
        next() { if (this.start + this.perPage < this.items.length) this.start++; },
        prev() { if (this.start > 0) this.start--; }
    }
}

function reviewsManager(productSlug) {
    return {
        reviews: [],
        displayedReviews: [],
        moreReviews: [],
        
        // Calculate average rating
        get averageRate() {
            if (this.reviews.length === 0) return 0;
            return this.reviews.reduce((sum, r) => sum + Number(r.rv_rate), 0) / this.reviews.length;
        },

        init() {
            // Fetch reviews from API
            fetch(`/api/products/${productSlug}/reviews`)
                .then(res => {
                    if (!res.ok) {
                        // Handle error
                        throw new Error('Failed to fetch reviews.');
                    }
                    return res.json();
                })
                .then(data => {
                    // Populate reviews when data is received
                    this.reviews = data.map(r => ({
                        id: r.id,
                        rv_rate: r.rv_rate,
                        rv_comment: r.rv_comment,
                        customer_name: r.customer_name || 'Anonymous'
                    }));
                    this.displayedReviews = this.reviews.slice(0, 5);
                    this.moreReviews = this.reviews.slice(5);
                })
                .catch(err => console.error(err));
        },

        loadMore() {
            // Take the next 5 reviews from moreReviews
            const nextFiveReviews = this.moreReviews.splice(0, 5);

            // Loop through each of them and push to displayedReviews
            nextFiveReviews.forEach((review) => {
                this.displayedReviews.push(review);
            });
        },
    }
}

</script>
@endsection
