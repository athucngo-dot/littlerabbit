<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function mainDashboard()
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $customer = Auth::guard('customer')->user();

        return view('dashboard.main-dashboard', compact('customer'));
    }
}
