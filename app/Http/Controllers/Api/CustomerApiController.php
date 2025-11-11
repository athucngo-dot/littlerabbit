<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CustomerNameRequest;
use App\Http\Requests\CustomerPasswordRequest;
use App\Models\Customer;
use App\Services\CustomerService;

class CustomerApiController extends Controller
{
    public function updateName(CustomerNameRequest $request)
    {
        if (!Auth::check()) {
            throw ValidationException::withMessages(['error' => 'Unauthorized to update customer information.']);
        }

        $updateData['first_name'] = $request->first_name;
        $updateData['last_name'] = $request->last_name;

        CustomerService::updateCustomerInfo(Auth::id(), $updateData);

        // Return a JSON response with success message and suggested items
        return response()->json([
            'success' => true,
            'message' => 'Update successfully.'
        ]);
    }

    public function updatePassword(CustomerPasswordRequest $request)
    {
        if (!Auth::check()) {
            throw ValidationException::withMessages(['error' => 'Unauthorized to update customer information.']);
        }

        $updateData['current_password'] = $request->current_password;
        $updateData['new_password'] = $request->new_password;

        CustomerService::updateCustomerInfo(Auth::id(), $updateData, 'password');

        // Return a JSON response with success message and suggested items
        return response()->json([
            'success' => true,
            'message' => 'Update successfully.'
        ]);
    }
}
