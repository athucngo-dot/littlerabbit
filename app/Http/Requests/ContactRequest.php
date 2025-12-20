<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Please enter your first name.',
            'first_name.string' => 'First name must be a string.',
            'first_name.max' => 'First name must not exceed :max characters.',
            
            'last_name.required' => 'Please enter your last name.',
            'last_name.string' => 'Last name must be a string.',
            'last_name.max' => 'Last name must not exceed :max characters.',
            
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Your email format is invalid.',
            'email.max' => 'Email must not exceed :max characters.',

            'message.required' => 'Please enter your message.',
            'message.string' => 'Message must be a string.',
        ];
    }
}
