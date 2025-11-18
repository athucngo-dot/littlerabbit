<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CustomerNameRequest;
use App\Http\Requests\CustomerPasswordRequest;
use App\Http\Requests\CustomerAddressRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use App\Services\AuthService;

class CustomerApiController extends Controller
{
    public function updateName(CustomerNameRequest $request)
    {
        AuthService::checkAuthorization();

        $updateData = $request->only([
            'first_name',
            'last_name',
        ]);

        CustomerService::updateCustomerInfo(Auth::id(), $updateData);

        // Return a JSON response with success message and suggested items
        return response()->json([
            'success' => true,
            'message' => 'Update successfully.'
        ]);
    }

    public function updatePassword(CustomerPasswordRequest $request)
    {
        AuthService::checkAuthorization();

        $updateData = $request->only([
            'current_password',
            'new_password',
        ]);

        CustomerService::updateCustomerInfo(Auth::id(), $updateData, 'password');

        // Return a JSON response with success message and suggested items
        return response()->json([
            'success' => true,
            'message' => 'Update successfully.'
        ]);
    }

    public function getAddress()
    {
        AuthService::checkAuthorization();

        $customer = Auth::user();
        $addresses = ['addresses' => $customer->addresses];

        return response()->json($addresses);
    }

    public function updateAddress($id, CustomerAddressRequest $request)
    {
        AuthService::checkAuthorization();

        $addressNewData = $request->only([
            'street',
            'city',
            'province',
            'postal_code',
            'country',
        ]);

        // Remove spaces and convert to uppercase
        $addressNewData['postal_code'] = strtoupper(preg_replace('/\s+/', '', $addressNewData['postal_code']));

        $success = CustomerService::updateCustomerAddress($id, Auth::id(), $addressNewData);

        if (!$success) {
            return response()->json([
                'success' => false,
                'message' => 'Address update failed.'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully.',
            'address' => $addressNewData
        ]);
    }

    public function addAddress(CustomerAddressRequest $request)
    {
        AuthService::checkAuthorization();

        $addressData = $request->only([
            'street',
            'city',
            'province',
            'postal_code',
            'country',
        ]);

        // Remove spaces and convert to uppercase
        $addressData['postal_code'] = strtoupper(preg_replace('/\s+/', '', $addressData['postal_code']));
        $addressData['customer_id'] = Auth::id();

        $newAddress = CustomerService::addCustomerAddress($addressData);

        return response()->json([
            'success' => true,
            'message' => 'Address added successfully.',
            'address' => $newAddress
        ]);
    }

    public function deleteAddress($id)
    {
        AuthService::checkAuthorization();

        CustomerService::deleteCustomerAddress($id);

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully.'
        ]);
    }
}
