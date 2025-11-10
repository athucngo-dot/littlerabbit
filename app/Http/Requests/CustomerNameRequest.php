<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerNameRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255']
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
        ];
    }
}
