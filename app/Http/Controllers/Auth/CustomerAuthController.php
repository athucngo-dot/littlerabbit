<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;

class CustomerAuthController extends Controller
{
    public function showLoginRegisterForm()
    {
        return view('auth.login-register'); // create this view
    }

    public function login(LoginRequest $request)
    {
        $loginData = $request->only('email', 'password');
        $loginData['is_active'] = true;
        
        $checkedRemember = $request->filled('remember');

        if (AuthService::login($loginData, $checkedRemember)) {
            return redirect()->intended(route('dashboard.main-dashboard')); // direct to customer dashboard
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.'])
                ->withInput();
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('homepage');
    }

    public function register(RegisterRequest $request)
    {
        $registerData = $request->only('firstname', 'lastname', 'register_email', 'register_password');
        $customer = AuthService::register($registerData);

        Auth::guard('customer')->login($customer);

        return redirect()->route('dashboard.main-dashboard');
    }
}
