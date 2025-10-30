@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-mint to-paper-2 py-16">
    <div class="max-w-4xl mx-auto text-center px-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">About Little Rabbit</h1>
        <img src="images/happy_about.webp" alt="Happy Children" class="mx-auto rounded-xl mb-4">
        
        <p class="text-lg text-gray-600 leading-relaxed mb-8">
        Welcome to <span class="font-semibold text-gray-800">Little Rabbit Kidswear</span>, 
        where fashion meets comfort for your little ones.  
        For over 10 years, we've been passionate about creating clothing that is not only 
        stylish but also safe, soft, and playful for children of all ages.
        </p>

        <p class="text-lg text-gray-600 leading-relaxed mb-8">
        Every piece in our collection is designed with love, using high-quality materials 
        that are gentle on kids' skin. From everyday essentials to special occasion outfits, 
        our goal is to make sure your child feels comfortable and confident.
        </p>

        <p class="text-lg text-gray-600 leading-relaxed">
        Thank you for trusting us to be part of your child's journey.  
        We're excited to keep bringing you clothing that makes both kids and parents smile.  
        <span class="font-semibold text-gray-800">Because every child deserves to shine!</span>
        </p>

        <!-- Demo Disclaimer -->
        <p class="bg-yellow-50 border border-yellow-200 rounded-lg mt-7 p-5 text-sm text-yellow-700">
            <strong class="block mb-2">Demo Notice:</strong>
            This website is for demonstration and educational purposes only. No real orders will be fulfilled, and no products will be shipped.
        </p>
    </div>
</section>

@endsection
