@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-mint to-paper-2">
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        {{-- Product Main Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- Left: Images Carousel with Thumbnails --}}
                <x-product.image-carousel
                    :images="$product->images->map(fn ($img) => $img->getImgUrl())"
                />

                {{-- Right: Product Info --}}
                <div class="space-y-6">
                    <p class="text-lg text-gray-600">{{ stripslashes($product->brand?->name) }}</p>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>

                    {{-- Average rating and review count --}}
                    <div x-data="reviewsManager('{{ $product->slug }}')" x-init="init()" class="flex items-center space-x-2 mt-2">
                        <x-product.reviews.stars size="sm" />
                        <span class="text-gray-600 text-sm" x-text="reviews.length + ' ratings'"></span>
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
                    @if ($product->price_after_deals != $product->price)
                        <p>
                            <span class="text-xl text-red-500">-{{ number_format($product->deals[0]->percentage_off) }}% </span>
                            <span class="text-2xl font-bold text-gray-900 px-2">${{ number_format($product->price_after_deals, 2) }}</span>
                        </p>
                        <p class="text-sm text-gray-900">Was: <span class="line-through px-2">${{ number_format($product->price, 2) }}</span></p>
                        @if ($product->deals->isNotEmpty())
                            <p class="text-sm text-gray-900">Eligible for the following discount(s):
                            @foreach ($product->deals as $deal)
                                {{ $deal->name }} (<span class="text-red-400">-{{ number_format($deal->percentage_off) }}%</span>) | </li>
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
                            @for ($i = 1; $i <= $product->max_quantity; $i++)
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
                    @if (!empty($product->features) || !empty($product->material))
                        <h4 class="font-bold text-gray-800 mb-2">Features</h4>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            @if (!empty($product->features))
                                @foreach ($product->features as $feature)
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
                <x-product.product-carousel :products="$relatedProducts->map(fn($p) => [
                    'id' => $p->id,
                    'slug' => $p->slug,
                    'name' => $p->name,
                    'url' => $p->thumbnail(),
                    'price' => $p->price
                ])->values()->toArray()" />

            </div>

            {{-- Recently Viewed Carousel --}}
            @if ($recentlyViewed->isNotEmpty())
                <div class="mt-16">
                    <h2 class="text-2xl font-bold mb-6">Recently Viewed</h2>
                    <x-product.product-carousel :products="$recentlyViewed->map(fn($p) => [
                        'id' => $p->id,
                        'slug' => $p->slug,
                        'name' => $p->name,
                        'url' => $p->thumbnail(),
                        'price' => $p->price
                    ])->values()->toArray()" />
                </div>
            @endif

            {{-- Reviews Section --}}
            <x-product.reviews.section :product-slug="$product->slug" />
        </div>
    </div>
    
    <!-- Popup here -->
    <x-popup-add-cart />
</section>

@endsection
