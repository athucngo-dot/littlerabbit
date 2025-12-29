<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CmsProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            
            // slug must be unique — except for the current product being edited.
            'slug' => ['required', 'string', 'max:255', 'unique:products,slug,' . $this->product?->id],
            'description' => ['nullable', 'string'],
            'features' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'nb_of_items' => ['required', 'integer', 'min:1'],
            'gender' => ['required', 'in:boy,girl,unisex'],
            'is_active' => ['boolean'],
            'new_arrival' => ['boolean'],

            'brand_id' => ['nullable', 'exists:brands,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'material_id' => ['nullable', 'exists:materials,id'],

            // validates each item inside the array color exists in colors table
            'colors' => ['nullable', 'array'],
            'colors.*' => ['exists:colors,id'],

            // validates each item inside the array size exists in sizes table
            'sizes' => ['nullable', 'array'],
            'sizes.*' => ['exists:sizes,id'],

            // validates each item inside the array deal exists in deals table
            'deals' => ['nullable', 'array'],
            'deals.*' => ['exists:deals,id'],

            // validates each item inside the array image
            // Must be a valid image file
            // Only allow formats jpg,jpeg,png,webp
            // Max size 2MB per image
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required.',
            'slug.required' => 'Slug is required.',
            'slug.unique' => 'This slug already exists.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
            'stock.required' => 'Stock is required.',
            'stock.integer' => 'Stock must be a whole number.',
            'nb_of_items.min' => 'Items per product must be at least 1.',

            'gender.required' => 'Gender is required.',
            'is_active.boolean' => 'Active must be true or false.',
            'new_arrival' => 'New Arrival must be true or false.',

            'brand_id.exists' => 'Selected brand does not exist.',
            'category_id.exists' => 'Selected category does not exist.',
            'material_id.exists' => 'Selected material does not exist.',

            'colors.*.exists' => 'One or more selected colors are invalid.',
            'sizes.*.exists' => 'One or more selected sizes are invalid.',
            'deals.*.exists' => 'One or more selected deals are invalid.',

            'images.*.image' => 'Each file must be an image.',
            'images.*.mimes' => 'Images must be jpg, jpeg, png, or webp.',
            'images.*.max' => 'Images must not exceed 2MB.',
        ];
    }
}
