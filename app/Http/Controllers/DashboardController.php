<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function mainDashboard()
    {
        $customer = Auth::guard('customer')->user();
        $addresses = $customer->addresses;
        $orders = $customer->orders()
            ->whereNotIn('status', ['pending', 'failed'])
            ->with('products')
            ->latest()
            ->limit(20)
            ->get();

        $orders->each(function ($order) {
            $order->products->each(function ($product) {
                $product->pivot->load(['color', 'size']);
            });

            $order->address = $order->addresses()->where('type', 'mailing')->first();
        });
                
        return view('dashboard.main-dashboard', compact('customer', 'addresses', 'orders'));
    }
}
