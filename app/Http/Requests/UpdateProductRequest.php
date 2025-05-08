<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'sometimes|string|min:1|max:255', 
            'description' => 'sometimes|string|max:1000',
            'quantity' => 'sometimes|integer|min:0',  
            'category_id' => 'sometimes|exists:categories,id', 
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'The product name is required.',
            'name.max' => 'The name cannot exceed 255 characters.',
            'quantity.integer' => 'The quantity must be an integer.',
            'quantity.min' => 'The quantity cannot be negative.',
            'category_id.exists' => 'The selected category does not exist.',
            'description.max' => 'The description cannot exceed 1000 characters.',
        ];
    }
}
