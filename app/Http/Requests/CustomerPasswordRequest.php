<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerPasswordRequest extends FormRequest
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
            'current_password' => ['required', 'string'],
            'new_password' => [
                'required',
                'string', 
                'min:8', // at least 8 characters
                'max:20', // maximum 20 characters
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).+$/', // at least one uppercase, one lowercase, one number and one special character
                      //(?=.*[a-z]) => requires at least one lowercase letter
                      //(?=.*[A-Z]) => requires at least one uppercase letter
                      //(?=.*\d) => requires at least one digit
                      //(?=.*[^a-zA-Z\d]) => requires at least one special character
                      //.+$ => ensures the entire string is checked
                'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Please enter your current password.',
            'current_password.string' => 'Current password must be a string.',

            'new_password.required' => 'Please enter your new password.',
            'new_password.string' => 'Your new password must be a string.',
            'new_password.min' => 'Your new password must be at least :min characters.',
            'new_password.max' => 'Your new password must not exceed :max characters.',
            'new_password.regex' => 'Your new password must contain at least one uppercase letter, one lowercase letter, one number and one special character.',
            'new_password.confirmed' => 'Your new password confirmation does not match.',
        ];
    }
}
