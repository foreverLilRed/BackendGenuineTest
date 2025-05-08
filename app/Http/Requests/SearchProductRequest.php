<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchProductRequest extends FormRequest
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
    public function rules(): array{
        return [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:1000',
            'min_quantity' => 'sometimes|numeric|min:0',
            'max_quantity' => 'sometimes|numeric|min:0',
            'category_name' => 'sometimes|string|max:255',
            'category_id' => 'sometimes|integer|exists:categories,id',
            'per_page' => 'sometimes|integer|min:1|max:100'
        ];
    }

    public function messages(){
        return [
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name must not exceed 255 characters.',
    
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description must not exceed 1000 characters.',
    
            'min_quantity.numeric' => 'The minimum quantity must be a number.',
            'min_quantity.min' => 'The minimum quantity cannot be negative.',
    
            'max_quantity.numeric' => 'The maximum quantity must be a number.',
            'max_quantity.min' => 'The maximum quantity cannot be negative.',
    
            'category_name.string' => 'The category name must be a string.',
            'category_name.max' => 'The category name must not exceed 255 characters.',
    
            'category_id.integer' => 'The category ID must be an integer.',
            'category_id.exists' => 'The selected category does not exist.',
    
            'per_page.integer' => 'The items per page value must be an integer.',
            'per_page.min' => 'You must display at least one item per page.',
            'per_page.max' => 'You cannot display more than 100 items per page.',
        ];
    }
    
}
