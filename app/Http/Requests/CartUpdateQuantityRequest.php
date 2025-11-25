<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartUpdateQuantityRequest extends FormRequest
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
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'size_id'    => ['required', 'integer', 'exists:sizes,id'],
            'color_id'   => ['required', 'integer', 'exists:colors,id'],
            'quantity'   => ['required', 'integer', 'min:1', 'max:' . config('site.cart.max_quantity')],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'A product is required.',
            'product_id.integer'    => 'Product must be a valid number.',
            'product_id.exists'   => 'Product does not exist.',
            
            'size_id.required'    => 'Size is required.',
            'size_id.integer'    => 'Size must be a valid number.',
            'size_id.exists'      => 'Size does not exist.',
            
            'color_id.required'   => 'Color is required.',
            'color_id.integer'    => 'Color must be a valid number.',
            'color_id.exists'     => 'Color does not exist.',

            'quantity.required'   => 'Please specify a quantity.',
            'quantity.integer'    => 'Quantity must be a valid number.',
            'quantity.min'        => 'Quantity must be at least :min.',
            'quantity.max'        => 'Quantity may not be greater than ' . config('site.cart.max_quantity'),
        ];
    }
}
