<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productoId = $this->route('producto'); // Captura el id_producto desde la URL

        return [
            'codigo_producto' => [
                'required',
                'string',
                'max:45',
                Rule::unique('producto', 'codigo_producto')->ignore($productoId, 'id_producto'),
            ],
            'referencia_producto' => 'nullable|string|max:100',
            'categoria_id' => 'required|exists:categorias,id_categorias',
            'tipo_madera' => 'nullable|string|max:45',
            'color_producto' => 'nullable|string|max:45',
            'precio_actual' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'imagenes' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Una sola imagen
            'descripcion_imagen' => 'nullable|string|max:255',
            ];
    }

    public function messages(): array
    {
        return [
            'codigo_producto.unique' => 'El código del producto ya está en uso.',
            'precio_actual.regex' => 'El precio debe tener máximo dos decimales.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
        ];
    }
}