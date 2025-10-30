@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-mint to-paper-2 py-16">
    <div class="max-w-4xl mx-auto px-6">
        <h1 class="text-3xl font-semibold mb-4 text-gray-900">Size Guide</h1>
        <p class="mb-8 text-gray-600">Find the perfect fit for your little one! Below is our size guide to help you choose the right size by age range.</p>


        <!-- Baby Sizes -->
        <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-200 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-3">Baby Sizes</h2>
            <ul class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-sm">
                <li class="bg-gray-100 rounded-md p-2 text-center">NB (Newborn 5-10 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">3M (0-3 months 10-12 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">6M (3-6 months 12-16 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">9M (6-9 months 16-20 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">12M (12 months 20-24 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">18M (18 months 24-28 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">24M (24 months 28-30 lbs)</li>
            </ul>
        </div>


        <!-- Toddler Sizes -->
        <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-200 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-3">Toddler Sizes</h2>
            <ul class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-sm">
                <li class="bg-gray-100 rounded-md p-2 text-center">2T (30-32 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">3T (32-35 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">4T (35-39 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">5T (39-45 lbs)</li>
            </ul>
        </div>


        <!-- Kids Sizes -->
        <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-200 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-3">Kids Sizes</h2>
            <ul class="grid grid-cols-2 sm:grid-cols-6 gap-2 text-sm">
                <li class="bg-gray-100 rounded-md p-2 text-center">4 (31-38 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">5 (37-48 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">6 (45-52 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">7 (50-55 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">8 (52-64 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">10 (62-80 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">12 (75-95 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">14 (88-98 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">16 (98-110 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">18 (110-115 lbs)</li>
                <li class="bg-gray-100 rounded-md p-2 text-center">20 (115-120 lbs)</li>
            </ul>
        </div>


        <!-- Demo Notice -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-5 text-sm text-yellow-700">
            <strong class="block mb-2">Demo Notice:</strong>
            This size guide is for portfolio and learning purposes only. No real products are sold.
        </div>
    </div>
</section>

@endsection
