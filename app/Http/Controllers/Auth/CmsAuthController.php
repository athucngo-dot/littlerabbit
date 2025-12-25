<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class CmsAuthController extends Controller
{
    /**
     * Log in form
     */
    public function showLoginForm()
    {
        return view('cms.auth.login');
    }

    /**
     * Authentication action
     */
    public function login(LoginRequest $request)
    {
        $loginData = $request->only('email', 'password');
        $loginData['is_active'] = true;

        if (Auth::guard('admin')->attempt($loginData)) {
            return redirect()->intended(route('cms.products.list'));
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    /**
     * Logout
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect(route('cms.login'));
    }
}
