<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class CustomerAuthController extends Controller
{
    public function showLoginRegisterForm()
    {
        return view('auth.login-register'); // create this view
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials, $request->filled('remember'))) {
            return redirect()->intended('/'); // customer dashboard or home
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ]);
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect('/');
    }

    public function register(RegisterRequest $request)
    {
        $customer = Customer::create([
            'first_name' => $request->firstname,
            'last_name'  => $request->lastname,
            'email'      => $request->register_email,
            'password'   => Hash::make($request->register_password),
        ]);

        Auth::guard('customer')->login($customer);

        return redirect('/');
    }
}
