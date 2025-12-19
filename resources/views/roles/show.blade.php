@extends('layouts.app')

@section('title', 'Detalles del Rol')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detalles del Rol</h1>
                <p class="text-sm text-gray-500 mt-1">ID: {{ $role->id_rol }}</p>
            </div>
            <div class="flex gap-2">
            <a href="{{ route('roles.edit', $role->id_rol) }}"
            class="px-3 py-1.5 bg-yellow-100 text-yellow-700 text-sm rounded-md font-medium hover:bg-yellow-200 transition">
                Editar
            </a>
            <a href="{{ route('roles.permisos', $role->id_rol) }}"
            class="px-3 py-1.5 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-lg font-medium transition shadow-sm">
                Permisos
            </a>
            <a href="{{ route('roles.index') }}"
            class="px-3 py-1.5 bg-gray-200 text-gray-800 text-sm rounded-md font-medium hover:bg-gray-300 transition">
                Volver
            </a>
        </div>
        </div>

        <div class="space-y-5">
            <!-- Nombre -->
            <div class="flex justify-between border-b border-gray-100 pb-3">
                <strong class="text-gray-700">Nombre:</strong>
                <span class="text-gray-900">{{ $role->nombre_rol }}</span>
            </div>

            <!-- Descripción -->
            <div class="flex justify-between border-b border-gray-100 pb-3">
                <strong class="text-gray-700">Descripción:</strong>
                <span class="text-gray-900 max-w-xs text-sm">
                    {{ $role->descripcion ?? 'Sin descripción' }}
                </span>
            </div>

            <!-- Usuarios asociados -->
            <div class="flex justify-between border-b border-gray-100 pb-3">
                <strong class="text-gray-700">Usuarios:</strong>
                <span class="text-gray-900">
                    {{ $role->usuarios()->count() }} usuarios asignados
                </span>
            </div>

            <!-- Permisos asociados -->
            <div class="flex justify-between border-b border-gray-100 pb-3">
                <strong class="text-gray-700">Permisos:</strong>
                <span class="text-gray-900">
                    {{ $role->permisos()->count() }} permisos asignados
                </span>
            </div>

            <!-- Fechas -->
            <div class="flex justify-between border-b border-gray-100 pb-3">
                <strong class="text-gray-700">Creado:</strong>
                <span class="text-gray-500 text-sm">
                    {{ $role->created_at?->format('d/m/Y H:i') ?? '—' }}
                </span>
            </div>
            <div class="flex justify-between pb-3">
                <strong class="text-gray-700">Actualizado:</strong>
                <span class="text-gray-500 text-sm">
                    {{ $role->updated_at?->format('d/m/Y H:i') ?? '—' }}
                </span>
            </div>
        </div>

        <!-- Acción de eliminación -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <form action="{{ route('roles.destroy', $role->id_rol) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('¿Está seguro de eliminar este rol? Esta acción es irreversible y afectará a todos los usuarios asignados a este rol.')"
                        class="px-4 py-2 bg-red-100 text-red-700 rounded-md text-sm font-medium hover:bg-red-200 transition">
                    Eliminar Rol
                </button>
            </form>
        </div>
    </div>
</div>
@endsection