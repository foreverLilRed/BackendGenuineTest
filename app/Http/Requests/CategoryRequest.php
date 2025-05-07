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

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la categoría es obligatorio.',
            'name.unique' => 'Ya existe una categoría con ese nombre.',
            'name.max' => 'El nombre de la categoría no puede tener más de 255 caracteres.',
            'name.min' => 'El nombre de la categoría tiene que tener como minimo 1 caracter.',
            'description.max' => 'La descripción no puede tener más de 500 caracteres.',
        ];
    }
}
