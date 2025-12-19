@extends('layouts.app')

@section('title', 'Asignar Permisos al Rol')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Asignar Permisos</h1>
            <p class="text-gray-600">Rol: <span class="font-medium">{{ $rol->nombre_rol }}</span></p>
        </div>
        <a href="{{ route('roles.index') }}" 
           class="px-3 py-1.5 bg-gray-200 text-gray-800 text-sm rounded-md font-medium hover:bg-gray-300 transition">
            Volver a Roles
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-center">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('roles.permisos.update', $rol) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <p class="text-sm text-gray-700 mb-3">
                Marque los permisos que desea asignar a este rol. Los permisos no seleccionados se desasignarán.
            </p>

            @if($permisos->isEmpty())
                <div class="bg-gray-50 p-4 rounded-md text-center text-gray-500">
                    No hay permisos disponibles.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($permisos as $permiso)
                        <label class="flex items-start space-x-3 cursor-pointer">
                            <input
                                type="checkbox"
                                name="permisos[]"
                                value="{{ $permiso->id_permiso }}"
                                {{ $rol->permisos->contains($permiso->id_permiso) ? 'checked' : '' }}
                                class="mt-1 h-4 w-4 text-marron-oscuro rounded focus:ring-marron-oscuro"
                            >
                            <div>
                                <div class="text-sm font-medium text-gray-900 font-mono">{{ $permiso->nombre_permiso }}</div>
                                <div class="text-xs text-gray-500">{{ $permiso->descripcion ?? 'Sin descripción' }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('roles.index') }}" 
               class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md font-medium hover:bg-gray-300 transition">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-lg font-medium transition shadow-sm">
                Guardar Permisos
            </button>
        </div>
    </form>
</div>
@endsection