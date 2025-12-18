@extends('layouts.app')

@section('title', 'Detalles de la Producción')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">

        {{-- Header --}}
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detalles de la Producción</h1>
                <p class="text-sm text-gray-500 mt-1">
                    ID: {{ $produccion->id_produccion }}
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('produccion.edit', $produccion->id_produccion) }}"
                   class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-md text-sm font-medium hover:bg-yellow-200 transition">
                    Editar
                </a>

                <a href="{{ route('produccion.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-medium hover:bg-gray-300 transition">
                    Volver
                </a>
            </div>
        </div>

        @php
            $estadoClases = match ($produccion->estado_produccion) {
                'TERMINADO'     => 'bg-green-100 text-green-800',
                'EN PROCESO'    => 'bg-yellow-100 text-yellow-800',
                'POR COMENZAR'  => 'bg-gray-100 text-gray-800',
                default         => 'bg-gray-100 text-gray-800',
            };
        @endphp

        {{-- Información --}}
        <div class="space-y-5">

            <div class="flex justify-between border-b pb-3">
                <span class="font-medium text-gray-700">Producto</span>
                <span class="text-right">
                    <div class="font-medium text-gray-900">
                        {{ $produccion->producto->codigo_producto }}
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $produccion->producto->referencia_producto ?? 'Sin referencia' }}
                    </div>
                </span>
            </div>

            <div class="flex justify-between border-b pb-3">
                <span class="font-medium text-gray-700">Cantidad producida</span>
                <span class="text-gray-900">
                    {{ $produccion->cantidad_producida }}
                </span>
            </div>

            <div class="flex justify-between border-b pb-3">
                <span class="font-medium text-gray-700">Fecha de inicio</span>
                <span class="text-gray-900">
                    {{ $produccion->fecha_inicio?->format('d/m/Y') ?? '—' }}
                </span>
            </div>

            <div class="flex justify-between border-b pb-3">
                <span class="font-medium text-gray-700">Fecha de finalización</span>
                <span class="text-gray-900">
                    {{ $produccion->fecha_fin?->format('d/m/Y') ?? '—' }}
                </span>
            </div>

            <div class="flex justify-between border-b pb-3 items-center">
                <span class="font-medium text-gray-700">Estado</span>
                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $estadoClases }}">
                    {{ $produccion->estado_produccion }}
                </span>
            </div>

            <div class="flex justify-between border-b pb-3">
                <span class="font-medium text-gray-700">Observaciones</span>
                <span class="text-gray-900 text-sm text-right max-w-sm">
                    {{ $produccion->observaciones ?? 'Sin observaciones' }}
                </span>
            </div>

            <div class="flex justify-between border-b pb-3">
                <span class="font-medium text-gray-700">Creado</span>
                <span class="text-sm text-gray-500">
                    {{ $produccion->created_at?->format('d/m/Y H:i') ?? '—' }}
                </span>
            </div>
        </div>

        {{-- Eliminar --}}
        <div class="mt-8 pt-6 border-t">
            <form action="{{ route('produccion.destroy', $produccion->id_produccion) }}" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit"
                        onclick="return confirm('¿Dar de baja este registro de producción?')"
                        class="px-4 py-2 bg-red-100 text-red-700 rounded-md font-medium hover:bg-red-200 transition">
                    Dar de baja registro
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
