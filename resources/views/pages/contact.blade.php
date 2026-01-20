@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-mint to-paper-2 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full space-y-12">
        <!-- Header -->
        <div class="text-center">
        <h2 class="text-3xl font-extrabold text-gray-900">Get in Touch</h2>
        <p class="mt-4 text-lg text-gray-600">
            We'd love to hear from you! Whether you have questions about our baby clothes, accessories, or orders, we're here to help.
        </p>
        </div>

        <!-- Contact Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition">
            <div class="text-2xl text-turmeric mb-2">📞</div>
            <h3 class="font-bold text-lg mb-1">Call Us</h3>
            <p class="text-gray-600">+1 (123) 456-7890</p>
            <p class="text-gray-400 text-sm">Mon-Fri, 9am-6pm</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition">
            <div class="text-2xl text-turmeric mb-2">✉️</div>
            <h3 class="font-bold text-lg mb-1">Email</h3>
            <p class="text-gray-600">support@littlerabbit.com</p>
            <p class="text-gray-400 text-sm">We'll reply within 24h</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition">
            <div class="text-2xl text-turmeric mb-2">📍</div>
            <h3 class="font-bold text-lg mb-1">Visit Us</h3>
            <p class="text-gray-600">1455 blv. De Maisonneuve Ouest</p>
            <p class="text-gray-600">Montreal, Quebec</p>
        </div>
        </div>

        <!-- Contact Form -->
        <div class="bg-white rounded-xl shadow-md p-8">
        <h3 class="text-xl font-bold mb-4 text-gray-900">Send Us a Message</h3>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">{{ session('success') }}</strong>
            </div>
        @endif
        <form action="{{ route('contact.send') }}" method="POST" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-turmeric">
            @error('first_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-turmeric">
            @error('last_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            </div>

            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-turmeric">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <input type="text" name="subject" placeholder="Subject"
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-turmeric">
            @error('subject')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <textarea name="user_message" rows="5" placeholder="Your Message" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-turmeric"></textarea>
            @error('user_message')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <button type="submit" class="w-full bg-aqua hover:bg-aqua-2 text-white font-semibold px-6 py-3 rounded-lg transition">
                Send Message
            </button>
        </form>
        </div>

        <!-- Demo Disclaimer -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-5 text-sm text-yellow-700">
            <strong class="block mb-2">Demo Notice:</strong>
            This website is for demonstration and educational purposes only. No real orders will be fulfilled, and no products will be shipped.
        </div>

    </div>
</section>

@endsection