<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    public function prepareForValidation()
    {
        // Convert empty/null to 0
        $this->merge([
            'address_id' => $this->address_id ?: 0, // unify empty → 0
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone_number' => [
                'required', 
                'string', 
                'max:15',
                'regex:/^\(\d{3}\)\d{3}-\d{4}$/' // Canadian phone numner format: (123)456-7890
            ],

            // address_id can be 0/null (new address) or existing address id
            'address_id' => [
                'nullable',
                'integer'
            ],

            // Required only when address_id is NOT provided
            'street'       => ['nullable', 'string', 'max:255'],
            'city'         => ['nullable', 'string', 'max:50'],
            'province'     => ['nullable', 'string', 'max:3'],
            'postal_code'  => [
                'nullable',
                'string', 
                'max:7',
                'regex:/^[A-Za-z]\d[A-Za-z]\s?\d[A-Za-z]\d$/i' // Canadian postal code format
            ],

            'country'      => ['nullable', 'string', 'max:50'],
            ];
    }

    /**
     * Configure the validator instance to add conditional rules.
     * - If address_id is provided, other address fields are not required, 
     *    and address_id must exists in table addresses.
     * - If address_id is not provided (0/null), other address fields are required.
     */
    public function withValidator($validator)
    {
        // require address_id to exist in addresses table if provided (address_id > 0)
        $validator->sometimes('address_id', [
            Rule::exists('addresses', 'id')
        ], function ($input) {
            return $input->address_id > 0;
        });

        // If address_id is 0 or not provided, require the following fields
        $validator->sometimes(['street','city','province','postal_code','country'], 'required', function ($input) {
            return $input->address_id == 0;
        });
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'Please enter your first name.',
            'first_name.string' => 'First name must be a string.',
            'first_name.max' => 'First name must not exceed :max characters.',
            
            'last_name.required' => 'Please enter your last name.',
            'last_name.string' => 'Last name must be a string.',
            'last_name.max' => 'Last name must not exceed :max characters.',

            'phone_number.string' => 'Phone Number must be a string.',
            'phone_number.max' => 'Phone Number must not exceed :max characters.',
            'phone_number.regex' => 'The Phone Number format is invalid. Example: (123)456-7890',

            'address_id.integer' => 'Address must be a valid number.',
            'address_id.exists' => 'The selected address does not exist.',
            
            'street.required_without' => 'Street is required when no saved address is selected.',
            'street.string' => 'Street must be a string.',
            'street.max' => 'Street must not exceed :max characters.',

            'city.required_without' => 'City is required when no saved address is selected.',
            'city.string' => 'City must be a string.',
            'city.max' => 'City must not exceed :max characters.',

            'province.required_without' => 'Province is required when no saved address is selected.',
            'province.string' => 'Province must be a string.',
            'province.max' => 'Province must not exceed :max characters.',

            'postal_code.required_without' => 'Postal Code is required when no saved address is selected.',
            'postal_code.string' => 'Postal Code must be a string.',
            'postal_code.max' => 'Postal Code must not exceed :max characters.',
            'postal_code.regex' => 'The postal code format is invalid. Example: A1A 1A1 or A1A1A1',

            'country.required_without' => 'Country is required when no saved address is selected.',
            'country.string' => 'Country must be a string.',
            'country.max' => 'Country must not exceed :max characters.',
        ];
    }
}
