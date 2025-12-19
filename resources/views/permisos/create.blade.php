@extends('layouts.app')

@section('title', 'Crear Nuevo Permiso')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-sm border border-gray-200">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Registrar Nuevo Permiso</h1>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('permisos.store') }}" method="POST">
        @csrf

        <div class="mb-5">
            <label for="nombre_permiso" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Permiso *</label>
            <input
                type="text"
                name="nombre_permiso"
                id="nombre_permiso"
                value="{{ old('nombre_permiso') }}"
                class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
                placeholder="Ej: crear_producto"
                maxlength="50"
                required
            >
            <p class="mt-1 text-xs text-gray-500">Nombre único que identifica el permiso (sin espacios, en minúsculas).</p>
        </div>

        <div class="mb-6">
            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción (opcional)</label>
            <textarea
                name="descripcion"
                id="descripcion"
                rows="2"
                class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
                maxlength="150"
                placeholder="Breve descripción del permiso"
            >{{ old('descripcion') }}</textarea>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('permisos.index') }}" 
               class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md font-medium hover:bg-gray-300 transition">Cancelar</a>
            <button type="submit" 
                    class="px-4 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-lg font-medium transition shadow-sm">
                Guardar Permiso
            </button>
        </div>
    </form>
</div>
@endsection