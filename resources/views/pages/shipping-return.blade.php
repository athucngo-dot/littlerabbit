@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-mint to-paper-2 py-16">
    <div class="max-w-4xl mx-auto px-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">Shipping & Returns</h1>
        <p class="mb-6 text-gray-600">Thank you for visiting Little Rabbit! We will try our best to fulfilled your requests.</p>

        <div class="space-y-10">
            <!-- Shipping Section -->
            <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-200">
                <h2 class="text-xl font-semibold mb-3 text-gray-900">Shipping</h2>
                <ul class="list-disc pl-5 space-y-2 text-sm">
                    <li>Standard shipping typically delivered in 5-7 business days</li>
                    <li>Express shipping available with 2-3 business day delivery</li>
                    <li>Free shipping on orders over $75</li>
                </ul>
            </div>


            <!-- Returns Section -->
            <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-200">
                <h2 class="text-xl font-semibold mb-3 text-gray-900">Returns</h2>
                <ul class="list-disc pl-5 space-y-2 text-sm">
                    <li>Returns accepted within 30 days of delivery</li>
                    <li>Products must be unused, unwashed, and in original packaging</li>
                    <li>Return shipping label available upon request</li>
                </ul>
            </div>


            <!-- Demo Disclaimer -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-5 text-sm text-yellow-700">
                <strong class="block mb-2">Demo Notice:</strong>
                This website is for demonstration and educational purposes only. No real orders will be fulfilled, and no products will be shipped.
            </div>
        </div>
    </div>
</section>

@endsection
