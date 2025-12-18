<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduccionRequest extends FormRequest
{
    // Determinar si el usuario está autorizado para realizar esta solicitud.
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtener las reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
     
    public function rules(): array
    {
        return [
            'producto_id' => 'required|exists:producto,id_producto',
            'cantidad_producida' => 'required|integer|min:1',
            'estado_produccion' => 'required|in:POR COMENZAR,EN PROCESO,TERMINADO',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'observaciones' => 'nullable|string|max:1000',
        ];
    }

    // Obtenga mensajes personalizados para errores del validador.
    public function messages(): array
    {
        return [
            'producto_id.required' => 'El campo producto es obligatorio.',
            'producto_id.exists' => 'El producto seleccionado no es válido.',
            'cantidad_producida.required' => 'La cantidad producida es obligatoria.',
            'cantidad_producida.integer' => 'La cantidad debe ser un número entero.',
            'cantidad_producida.min' => 'La cantidad producida debe ser al menos 1.',
            'cantidad_producida.max' => 'La cantidad no puede superar las 10,000 unidades.',
            'fecha_fin.after_or_equal' => 'La fecha de finalización debe ser igual o posterior a la fecha de inicio.',
            'estado_produccion.required' => 'El estado de producción es obligatorio.',
            'estado_produccion.in' => 'El estado seleccionado no es válido.',
            'observaciones.max' => 'Las observaciones no deben exceder los 1,000 caracteres.',
        ];
    }
}
