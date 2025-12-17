@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-mint to-paper-2 py-12 min-h-screen">

@if (session('error'))
    <div 
        x-data="{show:true}" 
        x-show="show" 
        x-init="setTimeout(()=>show=false,3000)"
        class="p-4 mb-4 text-red-700 text-center bg-red-100 border border-red-300 rounded-lg">
        {{ session('error') }}
    </div>
@endif

    <div x-data="window.loadCart()" 
        x-init="cartItems = @js($cartItems)">
        <div class="container mx-auto px-4 max-w-4xl">

            <!-- Page Title -->
            <h1 class="text-3xl font-bold text-gray-700 mb-8">Your Shopping Cart</h1>

            <!-- show if Empty Cart -->
            <div x-show="cartIsEmpty"
                class="bg-white p-10 rounded-xl shadow text-center">
                <p class="text-gray-500 text-lg mb-6">Your cart is currently empty.</p>

                <a href="{{ route('products.all-items') }}"
                class="px-6 py-3 bg-aqua hover:bg-aqua-2 text-white font-semibold rounded-xl">
                    Continue Shopping
                </a>
            </div>

            <!-- Cart Content - show if cart is not empty -->
            <div x-show="!cartIsEmpty"
                class="grid grid-cols-1 lg:grid-cols-3 gap-8 content-start">

                <!-- Cart Items List -->
                <div class="lg:col-span-2 gap-6 top-0 self-start">
                    <template x-for="item in cartItems" :key="item.product.id + '-' + item.color_id + '-' + item.size_id">
                        <div class="bg-white p-5 rounded-xl shadow flex gap-4 items-center mb-3">

                            <!-- Image -->
                            <img :src="item.product.image" 
                                :alt="item.product.name"
                                class="w-28 h-28 object-cover rounded-lg">

                            <div class="flex-1 flex flex-col justify-between h-full">

                                <!-- Product Name -->
                                <a :href="`{{ route('products.show', ':slug') }}`.replace(':slug', item.product.slug)"
                                    class="font-semibold text-lg hover:text-mint-600">
                                    <h3 x-text="item.product.name"></h3>
                                </a>

                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full border"
                                        :style="`background-color: ${item.color_hex || '#000'}`">
                                    </span>

                                    <span x-text="item.color" class="text-sm"></span>
                                    <span x-text="` / ${item.size}`" class="text-sm"></span>
                                </div>

                                <!-- Price with no deal-->
                                <div x-show="item.product.price === item.product.price_after_deals"
                                    x-text="`$${item.product.price_after_deals}`"
                                    class="text-gray-900 px-2">
                                </div>

                                <!-- Price with deal-->
                                <div x-show="item.product.price !== item.product.price_after_deals" 
                                    class="flex flex-col gap-1">
                                    
                                    <p>
                                        <span x-text="`-${item.product.discount}%`"
                                            class="text-red-500"></span>
                                        <span x-text="`$${item.product.price_after_deals}`" class="text-gray-900 px-2"></span>
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        (Was: 
                                        <span x-text="`$${item.product.price}`" class="line-through px-1"></span>)
                                    </p>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-4 mt-3">

                                    <!-- Quantity Update -->
                                    <select 
                                        x-model.number="item.quantity"
                                        @change="updateQuantity(item)"
                                        class="border rounded-lg px-2 py-1"
                                    >
                                        <template x-for="q in 10" :key="q">
                                            <option :value="q" x-text="q"></option>
                                        </template>
                                    </select>

                                    <!-- Remove Item -->
                                    <button @click="removeItem(item)"
                                        class="text-red-500 hover:text-red-700 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
                                            class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M8 6h8" />
                                            <path d="M10 6V4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2" />
                                            <path d="M19 6l-1 12a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                            <path d="M9 11v6" />
                                            <path d="M14 11v6" /> 
                                        </svg>
                                    </button>

                                </div>

                            </div>

                            <!-- Item Total Price -->
                            <p x-text="`$${getItemTotal(item)}`" class="font-semibold text-gray-700"></p>

                        </div>
                    </template>
                </div>

                <!-- Summary / Checkout -->
                <div class="bg-white p-6 rounded-xl shadow top-0 self-start">

                    <h2 class="text-xl font-bold text-gray-700 mb-4">Order Summary</h2>

                    <div class="space-y-2 mb-6 text-gray-600">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span x-text="`$${subTotalPrice().toFixed(2)}`" class="font-semibold text-gray-700"></span>
                        </div>

                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span x-text="`$${shippingCost().toFixed(2)}`" class="font-semibold text-gray-700"></span>
                        </div>

                        <div x-show="isFreeShipping" class="flex justify-between text-green-600 text-sm">
                            <span x-text="`You are qualified for free shipping (-$${shippingCost(false).toFixed(2)})`"></span>
                        </div>

                        <div class="flex justify-between text-lg font-semibold text-gray-800">
                            <span>Total</span>
                            <span x-text="`$${totalPrice().toFixed(2)}`"></span>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="space-y-3">
                        @php
                            $checkoutUrl = $allowCheckout ? 
                                        route('checkout') : 
                                        route('customer.login-register') . '?' . http_build_query(['ref' => 'cart']);
                        @endphp
                        <a href="{{$checkoutUrl}}"
                        class="block text-center px-5 py-3 bg-aqua hover:bg-aqua-2 text-white font-semibold rounded-xl">
                            Proceed to Checkout
                        </a>

                        <a href="{{ route('products.all-items') }}"
                        class="block text-center px-5 py-3 border border-gray-400 rounded-xl font-semibold text-gray-700 hover:bg-gray-100">
                            Continue Shopping
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </div>
</section>

<!-- Popup here -->
<x-popup-global />
@endsection
