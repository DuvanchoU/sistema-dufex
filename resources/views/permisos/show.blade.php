@extends('layouts.app')

@section('title', 'Detalles del Permiso')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="flex justify-between items-start mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detalles del Permiso</h1>
        <div class="space-x-2">
            <a href="{{ route('permisos.edit', $permiso->id_permiso) }}" 
               class="px-3 py-1.5 bg-yellow-100 text-yellow-700 text-sm rounded-md font-medium hover:bg-yellow-200 transition">Editar</a>
            <a href="{{ route('permisos.index') }}" 
               class="px-3 py-1.5 bg-gray-200 text-gray-800 text-sm rounded-md font-medium hover:bg-gray-300 transition">Volver</a>
        </div>
    </div>

    <div class="space-y-4">
        <div class="flex justify-between border-b border-gray-200 pb-2">
            <strong class="text-gray-700">ID:</strong>
            <span class="text-gray-900">{{ $permiso->id_permiso }}</span>
        </div>
        <div class="flex justify-between border-b border-gray-200 pb-2">
            <strong class="text-gray-700">Nombre:</strong>
            <span class="text-gray-900 font-mono">{{ $permiso->nombre_permiso }}</span>
        </div>
        <div class="flex justify-between border-b border-gray-200 pb-2">
            <strong class="text-gray-700">Descripción:</strong>
            <span class="text-gray-900">{{ $permiso->descripcion ?? 'No especificada' }}</span>
        </div>
    </div>

    @if($permiso->roles->count() > 0)
        <div class="mt-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Roles que tienen este permiso</h2>
            <div class="bg-blue-50 rounded-lg border border-blue-100 p-4">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($permiso->roles as $rol)
                        <li class="text-blue-800">{{ $rol->nombre_rol }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
@endsection