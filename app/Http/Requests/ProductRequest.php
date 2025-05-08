<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|string|min:1|max:255',
            'description' => 'nullable|string|max:1000',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function messages(): array{
        return [
            'name.required' => 'The product name is required.',
            'name.max' => 'The name must not exceed 255 characters.',
            'quantity.required' => 'The quantity is required.',
            'quantity.integer' => 'The quantity must be an integer.',
            'quantity.min' => 'The quantity cannot be negative.',
            'category_id.required' => 'The category is required.',
            'category_id.exists' => 'The selected category does not exist.',
            'description.max' => 'The description must not exceed 1000 characters.',
        ];
    }
}
