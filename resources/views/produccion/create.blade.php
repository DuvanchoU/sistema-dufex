@extends('layouts.app')

@section('title', 'Nueva Producción')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Registrar Nueva Producción</h1>
            <a href="{{ route('produccion.index') }}"
               class="text-sm text-gray-600 hover:text-gray-800 font-medium">← Volver</a>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg border border-red-100">
                <strong class="font-medium">Corrige los siguientes errores:</strong>
                <ul class="mt-2 list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('produccion.store') }}" method="POST">
            @csrf

            <!-- Producto -->
            <div class="mb-5">
                <label for="producto_id" class="block text-sm font-medium text-gray-700 mb-1">Producto *</label>
                <select
                    name="producto_id"
                    id="producto_id"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
                    required
                >
                    <option value="">-- Seleccione un producto --</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id_producto }}" {{ old('producto_id') == $producto->id_producto ? 'selected' : '' }}>
                            {{ $producto->codigo_producto }} – {{ $producto->referencia_producto ?? 'Sin referencia' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Cantidad producida -->
            <div class="mb-5">
                <label for="cantidad_producida" class="block text-sm font-medium text-gray-700 mb-1">Cantidad Producida *</label>
                <input
                    type="number"
                    name="cantidad_producida"
                    id="cantidad_producida"
                    value="{{ old('cantidad_producida', 1) }}"
                    min="1"
                    max="10000"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
                    required
                >
            </div>

            <!-- Fecha de inicio -->
            <div class="mb-5">
                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Inicio</label>
                <input
                    type="date"
                    name="fecha_inicio"
                    id="fecha_inicio"
                    value="{{ old('fecha_inicio') }}"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
                >
            </div>

            <!-- Fecha de fin -->
            <div class="mb-5">
                <label for="fecha_fin" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Finalización</label>
                <input
                    type="date"
                    name="fecha_fin"
                    id="fecha_fin"
                    value="{{ old('fecha_fin') }}"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
                >
            </div>

            <!-- Estado -->
            <div class="mb-5">
                <label for="estado_produccion" class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
                <select
                    name="estado_produccion"
                    id="estado_produccion"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
                    required
                >
                    <option value="">-- Seleccione estado --</option>
                    <option value="POR COMENZAR" {{ old('estado_produccion') == 'POR COMENZAR' ? 'selected' : '' }}>POR COMENZAR</option>
                    <option value="EN PROCESO" {{ old('estado_produccion') == 'EN PROCESO' ? 'selected' : '' }}>EN PROCESO</option>
                    <option value="TERMINADO" {{ old('estado_produccion') == 'TERMINADO' ? 'selected' : '' }}>TERMINADO</option>
                </select>
            </div>

            <!-- Observaciones -->
            <div class="mb-6">
                <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                <textarea
                    name="observaciones"
                    id="observaciones"
                    rows="3"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
                >{{ old('observaciones') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Máximo 1,000 caracteres.</p>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('produccion.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md font-medium hover:bg-gray-300 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-marron-oscuro text-white rounded-md font-medium hover:bg-[#5f3d2a] transition shadow-sm">
                    Guardar Producción
                </button>
            </div>
        </form>
    </div>
</div>
@endsection