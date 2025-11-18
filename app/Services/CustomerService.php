<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Address;

class CustomerService
{
    /**
     * Update Customer Info in DB
     */
    public static function updateCustomerInfo(int $customerId, array $updateData, string $type=''): void
    {
        $customer = self::validateCustomer($customerId);

        // Handle password update separately
        if ($type === 'password') {
            if (!Hash::check($updateData['current_password'], $customer->password)) {
                throw ValidationException::withMessages([
                    'current_password' => ['Current password is incorrect.'],
                ]);
            }

            // Hash the new password before saving
            $dbUpdateData['password'] = self::getHashedString($updateData['new_password']);
        
        } else {
            $dbUpdateData = $updateData;
        }

        $customer->update($dbUpdateData);
    }

    /**
     * Add Customer Address in DB
     */
    public static function addCustomerAddress(array $addressData): Address
    {
        self::validateCustomer($addressData['customer_id']);

        return Address::create($addressData); // add new row to address table
    }

    /**
     * Update Customer Address in DB
     */
    public static function updateCustomerAddress($addressId, $customerId, array $addressData): bool
    {
        self::validateCustomer($customerId);

        $address = Address::where('id', $addressId)
            ->where('customer_id', $customerId)
            ->firstOrFail();

        return $address->update($addressData);
    }

    /**
     * delete Customer Address in DB
     */
    public static function deleteCustomerAddress(int $addressId): void
    {
        Address::where('id', $addressId)
            ->where('customer_id', Auth::id())
            ->delete();
    }

    public static function getHashedString(string $theString): ?string
    {
        return Hash::make($theString);
    }

    private static function validateCustomer(int $customerId): Customer
    {
        $customer = Customer::where('id', $customerId)
                        ->firstOrFail();

        if (!$customer) {
            throw new \Exception("Customer not found.");
        }

        return $customer;
    }
}
