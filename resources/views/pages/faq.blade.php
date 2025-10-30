@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-mint to-paper-2 py-16">
    <div class="max-w-4xl mx-auto px-6">
        <h1 class="text-3xl font-semibold mb-4 text-gray-900">Frequently Asked Questions</h1>
        <p class="mb-8 text-gray-600">Welcome to our FAQ page! Below you'll find answers to common questions. This is a demo store for practice and portfolio purposes — no real orders or payments take place.</p>


        <div class="space-y-6">
            <!-- Question 1 -->
            <div class="bg-white shadow-sm rounded-lg p-5 border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Is this a real online store?</h2>
                <p class="text-sm">No, this is a demo store created to showcase design and development skills. Products are not for sale and checkout is simulated.</p>
            </div>


            <!-- Question 2 -->
            <div class="bg-white shadow-sm rounded-lg p-5 border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Will I receive any products if I place an order?</h2>
                <p class="text-sm">No. This is a practice environment and does not process real payments or ship physical goods.</p>
            </div>


            <!-- Question 3 -->
            <div class="bg-white shadow-sm rounded-lg p-5 border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">What technologies were used to build this site?</h2>
                <p class="text-sm">This project is built with Laravel, Tailwind CSS, and Alpine.js. The purpose is to learn, improve, and demonstrate skills in modern web development.</p>
            </div>


            <!-- Question 4 -->
            <div class="bg-white shadow-sm rounded-lg p-5 border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Can I contact you?</h2>
                <p class="text-sm">Absolutely! A contact page is provided for portfolio communication — feel free to reach out with feedback or collaboration ideas.</p>
            </div>


            <!-- Demo Notice -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-5 text-sm text-yellow-700">
                <strong class="block mb-2">Demo Notice:</strong>
                This website is for demonstration and educational purposes only. No real orders will be fulfilled, and no products will be shipped.
            </div>
        </div>
    </div>
</section>

@endsection
