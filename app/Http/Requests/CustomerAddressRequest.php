<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'street'      => 'required|string|max:255',
            'city'        => 'required|string|max:50',
            'province'    => 'required|string|max:3',
            'postal_code' => [
                'required',
                'string',
                'max:7',
                'regex:/^[A-Za-z]\d[A-Za-z]\s?\d[A-Za-z]\d$/i' // Canadian postal code format
            ],
            'country'     => 'required|string|max:50'
        ];
    }

    public function messages(): array
    {
        return [
            'street.required' => 'Please enter the street.',
            'street.string' => 'Street must be a string.',
            'street.max' => 'Street must not exceed :max characters.',
            
            'city.required' => 'Please enter the city.',
            'city.string' => 'City must be a string.',
            'city.max' => 'City must not exceed :max characters.',

            'province.required' => 'Please enter the province.',
            'province.string' => 'Province must be a string.',
            'province.max' => 'Province must not exceed :max characters.',

            'postal_code.required' => 'Please enter the postal code.',
            'postal_code.string' => 'Postal code must be a string.',
            'postal_code.max' => 'Postal code must not exceed :max characters.',
            'postal_code.regex' => 'The postal code format is invalid. Example: A1A 1A1 or A1A1A1',

            'country.required' => 'Please enter the country.',
            'country.string' => 'Country must be a string.',
            'country.max' => 'Country must not exceed :max characters.',
        ];
    }
}
