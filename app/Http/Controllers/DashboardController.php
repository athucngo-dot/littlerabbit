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
        
        return view('dashboard.main-dashboard', compact('customer', 'addresses'));
    }
}
