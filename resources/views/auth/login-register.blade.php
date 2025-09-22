@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-mint to-paper-2 p-6">
    <div class="w-full max-w-4xl bg-white shadow-lg rounded-2xl overflow-hidden grid md:grid-cols-2">
        
        {{-- Login Section --}}
        <div class="p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Login</h2>
            
            <form method="POST" action="/auth/login" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-base font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full mt-1 px-4 py-2 border rounded-lg 
                                focus:outline-none focus:ring-aqua focus:border-aqua @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-base font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required
                           class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-aqua focus:border-aqua @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                 {{-- Remember & Forgot --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" name="remember" id="remember" class="mr-2">
                        <label for="remember" class="px-2">Remember me</label>
                    </label>
                    <a href="/forget-password" class="text-sm text-aqua hover:underline">
                        Forgot password?
                    </a>
                </div>

                {{-- Submit --}}
                <button type="submit" 
                        class="w-full bg-aqua hover:bg-aqua-2 text-white py-2 rounded-lg font-semibold">
                    Login
                </button>
            </form>
        </div>

        {{-- Register Section --}}
        <div class="bg-gray-50 p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Create Account</h2>
            
            <form method="POST" action="/auth/register" class="space-y-4">
                @csrf

                {{-- First Name --}}
                <div>
                    <label for="fistname" class="block text-base font-medium text-gray-700">First Name</label>
                    <input id="firstname" type="text" name="firstname" value="{{ old('firstname') }}" required
                           class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-aqua focus:border-aqua @error('firstname') border-red-500 @enderror">
                    @error('firstname')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Last Name --}}
                <div>
                    <label for="lastname" class="block text-base font-medium text-gray-700">Last Name</label>
                    <input id="lastname" type="text" name="lastname" value="{{ old('lastname') }}" required
                           class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-aqua focus:border-aqua @error('lastname') border-red-500 @enderror">
                    @error('lastname')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="register_email" class="block text-base font-medium text-gray-700">Email</label>
                    <input id="register_email" type="email" name="register_email" value="{{ old('register_email') }}" required
                           class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-aqua focus:border-aqua @error('register_email') border-red-500 @enderror">
                    @error('register_email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="register_password" class="block text-base font-medium text-gray-700">Password</label>
                    <input id="register_password" type="password" name="register_password" required
                           class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-aqua focus:border-aqua @error('register_password') border-red-500 @enderror">
                    @error('register_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <span class="text-xs text-gray-700">8-20 characters long<br>
                          Includes uppercase letter, lowercase letter, number and special character
                    </span>
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="register_password_confirmation" class="block text-base font-medium text-gray-700">Confirm Password</label>
                    <input id="register_password_confirmation" type="password" name="register_password_confirmation" required
                           class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-aqua focus:border-aqua">
                </div>

                {{-- Submit --}}
                <button type="submit" 
                        class="w-full bg-aqua hover:bg-aqua-2 text-white py-2 rounded-lg font-semibold">
                    Register
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
