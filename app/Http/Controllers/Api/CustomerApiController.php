<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\CustomerNameRequest;
use App\Http\Requests\CustomerPasswordRequest;
use App\Models\Customer;
use App\Services\CustomerService;

class CustomerApiController extends Controller
{
    public function updateName(CustomerNameRequest $request)
    {
        try {
            $updateData['first_name'] = $request->first_name;
            $updateData['last_name'] = $request->last_name;

            CustomerService::updateCustomerInfo($request->customer_id, $updateData);

            // Return a JSON response with success message and suggested items
            return response()->json([
                'success' => true,
                'message' => 'Update successfully.'
            ]);

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error updating customer name: ' . $e->getMessage());

            // Return a JSON response with error message
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updatePassword(CustomerPasswordRequest $request)
    {
        $updateData['current_password'] = $request->current_password;
        $updateData['new_password'] = $request->new_password;

        CustomerService::updateCustomerInfo($request->customer_id, $updateData, 'password');

        // Return a JSON response with success message and suggested items
        return response()->json([
            'success' => true,
            'message' => 'Update successfully.'
        ]);
    }
}
