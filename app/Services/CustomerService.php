<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class CustomerService
{
    /**
     * Update Customer Info in DB
     */
    public static function updateCustomerInfo(int $customerId, array $updateData, string $type=''): void
    {
        $customer = Customer::where('id', $customerId)
                        ->firstOrFail();

        if (!$customer) {
            throw new \Exception("Customer not found.");
        }

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

    public static function getHashedString(string $theString): ?string
    {
        return Hash::make($theString);
    }
}
