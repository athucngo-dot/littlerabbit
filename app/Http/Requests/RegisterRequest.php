<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'register_email' => ['required', 'email:rfc', 'unique:customers,email'],
            'register_password' => [
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
            'firstname.required' => 'Please enter your first name.',
            'firstname.string' => 'First name must be a string.',
            'firstname.max' => 'First name must not exceed :max characters.',
            
            'lastname.required' => 'Please enter your last name.',
            'lastname.string' => 'Last name must be a string.',
            'lastname.max' => 'Last name must not exceed :max characters.',
            
            'register_email.required' => 'Please enter your email address.',
            'register_email.email' => 'Your email format is invalid.',
            'register_email.unique' => 'This email is already registered.',

            'register_password.required' => 'Please enter your password.',
            'register_password.string' => 'Password must be a string.',
            'register_password.min' => 'Your password must be at least :min characters.',
            'register_password.max' => 'Your password must not exceed :max characters.',
            'register_password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character.',
            'register_password.confirmed' => 'Your password confirmation does not match.',
        ];
    }
}
