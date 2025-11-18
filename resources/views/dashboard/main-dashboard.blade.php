@extends('layouts.app')

@section('content')

<div x-data="{ tab: 'orders', nameTab: 'fullname' }" class="min-h-screen bg-gradient-to-b from-mint to-paper-2 flex">
    <!-- Sidebar -->
    <div class="w-1/4 bg-white/80 backdrop-blur shadow-lg p-6 flex flex-col gap-6 border-r border-gray-200">
        <h2 class="text-2xl font-bold text-gray-700 text-center mb-4">{{ucwords($customer->last_name)}}'s Account</h2>

        <nav class="flex flex-col gap-3">
            <button @click="tab = 'orders'"
                :class="tab === 'orders' ? 'active-tab' : ''"
                class="dashboard-tab">
                    Your Orders
            </button>
            <button @click="tab = 'personalinfo'"
                :class="tab === 'personalinfo' ? 'active-tab' : ''"
                class="dashboard-tab">
                    Personal Info
            </button>
            <a href="{{ route('customer.logout') }}" class="dashboard-tab">
                Logout
            </a>
        </nav>
    </div>

    <!-- Content -->
    <div class="w-4/5 p-8">
        <!-- ORDERS SECTION (default) -->
        <div x-show="tab === 'orders'" x-transition>
            <h1 class="text-2xl font-bold mb-4">Your Orders</h1>

            <div class="bg-white shadow rounded-lg p-4">
                <p class="text-gray-600">List customer orders here…</p>
            </div>
        </div>

        <!-- PERSONAL INFO SECTION -->
        <div x-show="tab === 'personalinfo'" x-transition>
            <div class="bg-white shadow rounded-lg p-6 grid gap-4">
                @include('dashboard.partials.personal-info')
            </div>  
            <div class="bg-white shadow rounded-lg mt-6 p-6 grid gap-4">
                @include('dashboard.partials.email-password')
            </div>
            <div class="bg-white shadow rounded-lg mt-6 p-6 grid gap-4">
                @include('dashboard.partials.addresses')
            </div>     
        </div>

    </div>
</div>

<!-- Popup here -->
<x-popup-global />

@endsection
