<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function mainDashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('homepage');
        }

        $customer = Auth::guard('customer')->user();
        $addresses = $customer->addresses;
        $allowedNewAddress = count($addresses) < config('site.customer.max_addresses') ? true : false;

        return view('dashboard.main-dashboard', compact('customer', 'addresses', 'allowedNewAddress'));
    }
}
