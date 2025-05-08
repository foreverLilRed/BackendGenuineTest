<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|string|min:1|max:255|unique:categories,name', 
            'description' => 'nullable|string|max:500', 
        ];
    }

    public function messages(): array{
        return [
            'name.required' => 'The category name is required.',
            'name.unique' => 'A category with this name already exists.',
            'name.max' => 'The category name must not exceed 255 characters.',
            'name.min' => 'The category name must be at least 1 character.',
            'description.max' => 'The description must not exceed 500 characters.',
        ];
    }
    
}
