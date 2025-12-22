<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateCustomer
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::guard('customer')->check()) {
            // Handle unauthenticated request for JSON
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated'], 401);
            }

            // Custom redirect for checkout routes
            if ($request->is('checkout*')) {
                return redirect()->route('cart.index', ['ref' => 'cart']);
            }

            return redirect()->route('customer.login-register');
        }

        return $next($request);
    }
}
