<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthService
{
    public static function register(array $data): Customer
    {
        return Customer::create([
            'first_name' => $data['firstname'],
            'last_name'  => $data['lastname'],
            'email'      => $data['register_email'],
            'password'   => Hash::make($data['register_password']),
        ]);
    }

    public static function login(array $data, $checkedRemember = false): ?Customer
    {
        if (Auth::guard('customer')->attempt($data, $checkedRemember)) {
            return Auth::guard('customer')->user();
        }

        return null;
    }
}
