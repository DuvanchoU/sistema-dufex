<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermisoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_permiso' => 'required|string|max:50|unique:permisos,nombre_permiso',
            'descripcion' => 'nullable|string|max:150',
        ];
    }

    public function messages()
    {
        return [
            'nombre_permiso.unique' => 'Ya existe un permiso con ese nombre.',
            'nombre_permiso.required' => 'El nombre del permiso es obligatorio.',
        ];
    }
}