@extends('cms.layouts.app')

@section('content')

<main class="flex-1 flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white backdrop-blur-md rounded-2xl shadow-xl p-8">
        
        <!-- Title -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">
                Log In
            </h1>
        </div>

        <!-- Login Form -->
        <form action="{{ route('cms.login') }}" method="POST" class="space-y-5">
            @csrf
            <!-- Email -->
            <div>
                <label class="block text-base font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full mt-1 px-4 py-2 border rounded-lg 
                            focus:outline-none focus:ring-aqua focus:border-aqua @error('email') border-red-500 @enderror"
                />
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-base font-medium text-gray-700 mb-1 mt-4">
                    Password
                </label>
                <input type="password" name="password" required
                    class="w-full mt-1 px-4 py-2 border rounded-lg 
                            focus:outline-none focus:ring-aqua focus:border-aqua"
                />
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <button
                type="submit"
                class="w-full bg-aqua hover:bg-aqua-2 text-white py-2 mt-4 rounded-lg font-semibold"
            >
                Log In
            </button>
        </form>
    </div>
</main>

@endsection