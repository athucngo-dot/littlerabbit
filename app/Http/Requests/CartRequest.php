<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
            'product_slug' => ['required', 'exists:products,slug'],
            'size_id'    => ['required', 'exists:sizes,id'],
            'color_id'   => ['required', 'exists:colors,id'],
            'quantity'   => ['required', 'integer', 'min:1', 'max:' . config('site.cart.max_quantity')],
        ];
    }

    public function messages(): array
    {
        return [
            'product_slug.required' => 'A product is required.',
            'product_slug.exists'   => 'Product does not exist.',
            
            'size_id.required'    => 'Please select a size.',
            'size_id.exists'      => 'Size does not exist.',
            
            'color_id.required'   => 'Please select a color.',
            'color_id.exists'     => 'Color does not exist.',

            'quantity.required'   => 'Please specify a quantity.',
            'quantity.integer'    => 'Quantity must be a valid number.',
            'quantity.min'        => 'Quantity must be at least :min.',
            'quantity.max'        => 'Quantity may not be greater than ' . config('site.cart.max_quantity'),
        ];
    }
}
