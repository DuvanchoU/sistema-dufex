@extends('layouts.app')

@section('title', 'Editar Proveedor')

@section('content')
<div class="bg-[#F8F5F0] min-h-screen px-6 py-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Editar Proveedor</h1>
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

            <form action="{{ route('proveedores.update', $proveedor) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nombre -->
                <div class="mb-5">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Proveedor *</label>
                    <input
                        type="text"
                        name="nombre"
                        id="nombre"
                        value="{{ old('nombre', $proveedor->nombre) }}"
                        maxlength="100"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
                        required
                    >
                </div>

                <!-- Teléfono -->
                <div class="mb-5">
                    <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                    <input
                        type="text"
                        name="telefono"
                        id="telefono"
                        value="{{ old('telefono', $proveedor->telefono) }}"
                        maxlength="20"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
                    >
                </div>

                <!-- Correo -->
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', $proveedor->email) }}"
                        maxlength="100"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
                    >
                </div>

                <!-- Dirección -->
                <div class="mb-5">
                    <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                    <textarea
                        name="direccion"
                        id="direccion"
                        rows="2"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
                    >{{ old('direccion', $proveedor->direccion) }}</textarea>
                </div>

                <!-- Estado -->
                <div class="mb-6">
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
                    <select
                        name="estado"
                        id="estado"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
                        required
                    >
                        <option value="">-- Seleccione estado --</option>
                        <option value="ACTIVO" {{ (old('estado', $proveedor->estado) == 'ACTIVO') ? 'selected' : '' }}>ACTIVO</option>
                        <option value="INACTIVO" {{ (old('estado', $proveedor->estado) == 'INACTIVO') ? 'selected' : '' }}>INACTIVO</option>
                    </select>
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('proveedores.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md font-medium hover:bg-gray-300 transition">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-lg font-medium transition shadow-sm">
                        Actualizar Proveedor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection