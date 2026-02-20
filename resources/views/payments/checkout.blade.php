@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-mint to-paper-2 py-12 min-h-screen">
    <div class="container mx-auto px-4 max-w-4xl">

        <!-- Page Title -->
        <h1 class="text-3xl font-bold text-gray-700 mb-8">Checkout</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Billing & Shipping Form -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow space-y-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Delivery to</h2>

                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="text-sm text-gray-600">First Name</label>
                            <input id="first_name" type="text" name="first_name" value="{{ old('first_name', $customer->first_name ?? '') }}" required
                                class="w-full border rounded-lg px-3 py-2"> 
                            <p id="first_name-error" class="text-red-500 text-sm mt-1"></p>                    
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Last Name</label>
                            <input id="last_name" type="text" name="last_name" value="{{ old('last_name', $customer->last_name ?? '') }}" required
                                class="w-full border rounded-lg px-3 py-2">
                            <p id="last_name-error" class="text-red-500 text-sm mt-1"></p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-sm text-gray-600">Phone Number</label>
                        <input id="phone_number"  type="text" class="w-full border rounded-lg px-3 py-2">
                        <span class="text-xs text-gray-700">Eg. (123)456-7890</span>
                        <p id="phone_number-error" class="text-red-500 text-sm mt-1"></p>
                    </div>

                    <div x-data="{ selectedAddress: {{ $addresses->first()?->id ?? 'null' }} }">
                        <h2 class="text-xl font-semibold text-gray-700 mt-6 mb-4">Choose Shipping Address</h2>
                        <p id="address-error" class="text-red-500 text-sm mt-1"></p>

                        @foreach($addresses as $address)                            
                            <label class="flex items-start space-x-2 mb-2 cursor-pointer">
                                <input 
                                    type="radio"
                                    id="address_{{ $address->id }}" 
                                    name="address_id"
                                    value="{{ $address->id }}"
                                    x-model="selectedAddress"
                                    class="h-5 w-5"
                                >
                                <div>
                                    <p class="text-sm text-gray-600">
                                        {{ $address->street }}, {{ $address->city }}, 
                                        {{ $address->province }}, {{ $address->postal_code }},
                                        {{ $address->country }}</p>
                                </div>
                            </label>                            
                        @endforeach

                        <!-- NEW ADDRESS BUTTON -->
                        <button 
                            type="button"
                            @click="selectedAddress = 'new'"
                            class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg">
                            New Address
                        </button>

                        <!-- NEW ADDRESS FORM -->
                        <div x-show="selectedAddress === 'new'" x-transition class="mt-4">
                            <div class="mb-4">
                                <label class="text-sm text-gray-600">Street</label>
                                <input type="text" id="street" name="street" class="w-full border rounded-lg px-3 py-2">
                                <p id="street-error" class="text-red-500 text-sm mt-1"></p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="text-sm text-gray-600">City</label>
                                    <input type="text" id="city" name="city" class="w-full border rounded-lg px-3 py-2">
                                    <p id="city-error" class="text-red-500 text-sm mt-1"></p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">Province</label>
                                    <select id="province" name="province" class="w-full border text-gray-600 rounded-lg p-2">
                                        @include('dashboard.partials.list-province')
                                    </select>
                                    <p id="province-error" class="text-red-500 text-sm mt-1"></p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">Postal Code</label>
                                    <input type="text" id="postal_code" name="postal_code" class="w-full border rounded-lg px-3 py-2">
                                    <span class="text-xs text-gray-700">Eg. A1AA1A or A1A A1A</span>
                                    <p id="postal_code-error" class="text-red-500 text-sm mt-1"></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>    
                                    <label class="text-sm text-gray-600">Country</label>
                                    <select id="country" name="country" class="w-full text-gray-600 border rounded-lg p-2">
                                        <option value="Canada">Canada</option>
                                    </select>
                                    <p id="country-error" class="text-red-500 text-sm mt-1"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information (Stripe Demo) -->
                    <div class="bg-white p-6 rounded-xl shadow mt-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-700 mb-4">Payment Information</h2>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-5 text-sm text-yellow-700 mb-4">
                            <strong class="block mb-2">Demo Notice:</strong>
                                Note that this is only a demo payment process, <strong>please using test card</strong>. No real payment will be processed, no real orders will be fulfilled, and no products will be shipped.
                        </div>

                        <!-- Stripe Card Element Placeholder -->
                        <div id="card-element" class="border rounded-xl px-4 py-3 bg-white"></div>
                        <div id="card-errors" class="text-red-500 text-sm mt-2"></div>
                    </div>
                </form>
                <script src="https://js.stripe.com/v3/"></script>
                @vite('resources/js/checkout/stripe.js')
            </div>

            <!-- Order Summary -->
            <div class="bg-white p-6 rounded-xl shadow h-max">
                <h2 class="text-xl font-bold text-gray-700 mb-4">Order Summary</h2>

                <div class="space-y-2 mb-6 text-gray-600">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span class="font-semibold">${{$subtotal}}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Shipping</span>
                        <span class="font-semibold">${{number_format($shippingCost, 2)}}</span>
                    </div>

                    @if($shippingCost == 0)
                        <div class="flex justify-between text-green-600 text-sm">
                            <span x-show="{{$shippingCost == 0}}">Free Shipping Applied for Orders over 50$</span>
                        </div>
                    @endif

                    <div class="flex justify-between text-lg font-semibold text-gray-800">
                        <span>Total</span>
                        <span>${{$total}}</span>
                        <input type="hidden" data-total value="{{ $total }}">
                    </div>
                </div>

                <button id="pay-btn" class="w-full text-center px-5 py-3 bg-aqua hover:bg-aqua-2 text-white font-semibold rounded-xl">
                    Place Order
                </button>
            </div>

        </div>

    </div>
</section>
@endsection