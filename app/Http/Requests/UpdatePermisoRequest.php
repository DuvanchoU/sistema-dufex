<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermisoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $permiso = $this->route('permiso');
        return [
            'nombre_permiso' => 'required|string|max:50|unique:permisos,nombre_permiso,' . $permiso->id_permiso . ',id_permiso',
            'descripcion' => 'nullable|string|max:150',
        ];
    }

    public function messages()
    {
        return [
            'nombre_permiso.unique' => 'Ya existe un permiso con ese nombre.',
        ];
    }
}