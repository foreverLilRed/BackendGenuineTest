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
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',

            'description.string' => 'La descripción debe ser una cadena de texto.',
            'description.max' => 'La descripción no debe exceder los 1000 caracteres.',

            'min_quantity.numeric' => 'La cantidad mínima debe ser un número.',
            'min_quantity.min' => 'La cantidad mínima no puede ser negativa.',

            'max_quantity.numeric' => 'La cantidad máxima debe ser un número.',
            'max_quantity.min' => 'La cantidad máxima no puede ser negativa.',

            'category_name.string' => 'El nombre de la categoría debe ser una cadena de texto.',
            'category_name.max' => 'El nombre de la categoría no debe exceder los 255 caracteres.',

            'category_id.integer' => 'El ID de la categoría debe ser un número entero.',
            'category_id.exists' => 'La categoría seleccionada no existe.',

            'per_page.integer' => 'El valor de elementos por página debe ser un número entero.',
            'per_page.min' => 'Debe mostrar al menos un elemento por página.',
            'per_page.max' => 'No se pueden mostrar más de 100 elementos por página.',
        ];
    }
}
