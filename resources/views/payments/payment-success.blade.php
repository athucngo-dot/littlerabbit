@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-mint to-paper-2 min-h-screen py-16">
    <div class="max-w-3xl mx-auto px-4">

        <!-- Success/Info Card -->
        <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
            @if($status == 'error')
                <p class="text-gray-600 mb-6">
                    Oops! {{ $message ?? 'There was something wrong.' }}
                </p>
            @else
                <!-- Check Icon -->
                <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>

                <!-- Payment Processing Message -->
                <h1 class="text-3xl font-semibold text-gray-800 mb-2">
                    Thank you for your order!
                </h1>

                <p class="text-gray-600 mb-1">
                    Your payment is being processed.
                </p>

                <!-- Order Info -->
                <div class="bg-gray-50 rounded-xl p-6 text-left mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500 text-sm">Order Number</span>
                        <span class="font-medium text-gray-800">
                            {{ $order->order_number ?? '—' }}
                        </span>
                    </div>

                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500 text-sm">Total Paid</span>
                        <span class="font-medium text-gray-800">
                            ${{ number_format($order->total ?? 0, 2) }}
                        </span>
                    </div>

                    @if($payment)
                        <div class="flex justify-between">
                            <span class="text-gray-500 text-sm">Payment Method</span>
                            <span class="font-medium text-gray-800">
                                {{ ucfirst($payment?->card_brand) ?? '****' }} Card ending with {{ $payment?->card_last_four ?? '****' }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Delivery Info -->
                <div class="bg-gray-50 rounded-xl p-6 text-left mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500 text-sm">Delivery Address</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-800">
                            <p>{{ ucwords($address->first_name) ?? '' }} {{ ucwords($address->last_name) ?? '' }}</p>

                            <p>{{ ucwords($address->street) ?? '' }}, {{ ucwords($address->city) ?? '' }}, 
                                {{ ucwords($address->province) ?? '' }}, {{ strtoupper($address->postal_code) ?? '' }}, 
                                {{ ucwords($address->country) ?? '' }}</p>
                        </span>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('dashboard.main-dashboard') }}"
                    class="inline-flex justify-center items-center px-6 py-3 rounded-xl bg-aqua text-white font-semibold hover:bg-aqua-2 transition">
                        View Order
                    </a>

                    <a href="{{ route('products.all-items') }}"
                    class="inline-flex justify-center items-center px-6 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                        Continue Shopping
                    </a>
                </div>
            @endif
        </div>

        <!-- Demo Notice -->
        <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-2xl p-6">
            <h2 class="text-lg font-semibold text-yellow-800 mb-2">
                ⚠️ Demo Notice
            </h2>

            <p class="text-yellow-700 text-sm leading-relaxed">
                This checkout flow is part of a <strong>demo application</strong>.
                No real payment was processed, and no actual charges were made.
                All transactions use <strong>test mode</strong> for development
                and portfolio demonstration purposes only.
            </p>
        </div>

    </div>
</section>
@endsection