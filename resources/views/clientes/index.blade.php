@extends('layouts.app')

@section('title', 'Listado de Clientes')

@section('content')
<div class="bg-[#F8F5F0] min-h-screen px-6 py-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Clientes</h1>
        <a href="{{ route('clientes.create') }}"
           class="px-4 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-lg font-medium transition shadow-sm">
            + Nuevo Cliente
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Panel de Filtros Horizontal -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6">
        <form method="GET" action="{{ route('clientes.index') }}" class="flex flex-wrap items-end gap-3">

            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-700">Nombre o Apellido</label>
                <input type="text" name="nombre" value="{{ request('nombre') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm"
                       placeholder="Ej: Juan Pérez">
            </div>

            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-700">Teléfono</label>
                <input type="text" name="telefono" value="{{ request('telefono') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm"
                       placeholder="Ej: 3101234567">
            </div>

            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-700">Correo</label>
                <input type="text" name="email" value="{{ request('email') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm"
                       placeholder="ejemplo@hotmail.com">
            </div>

            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-700">Dirección</label>
                <input type="text" name="direccion" value="{{ request('direccion') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm"
                       placeholder="Calle 80 # 71-40, Bogotá">
            </div>

            <div class="flex-1 min-w-36">
                <label class="block text-xs font-medium text-gray-700">Fecha</label>
                <input type="date" name="fecha" value="{{ request('fecha') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
            </div>

            <div class="flex-1 min-w-36">
                <label class="block text-xs font-medium text-gray-700">Estado</label>
                <select name="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
                    <option value="">Todos</option>
                    <option value="ACTIVO" {{ request('estado') == 'ACTIVO' ? 'selected' : '' }}>ACTIVO</option>
                    <option value="INACTIVO" {{ request('estado') == 'INACTIVO' ? 'selected' : '' }}>INACTIVO</option>
                </select>
            </div>

            <div class="flex gap-2 mt-1">
                <button type="submit" class="px-6 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-md font-medium transition">
                    Aplicar
                </button>
                <a href="{{ route('clientes.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md font-medium transition">
                    Limpiar
                </a>
            </div>

        </form>
    </div>

    <!-- Tabla de Clientes -->
    @if ($clientes->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center text-gray-500">
            No hay clientes que coincidan con los filtros.
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dirección</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Registro</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($clientes as $c)
                        @php
                            $estadoClases = match($c->estado) {
                                'ACTIVO'   => 'bg-green-100 text-green-800',
                                default    => 'bg-red-100 text-red-800',
                            };
                        @endphp

                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $c->nombre }} {{ $c->apellido ?? '' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $c->telefono ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $c->email ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $c->direccion ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $c->fecha_registro ? $c->fecha_registro->format('d/m/Y') : '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2.5 py-0.5 inline-flex text-xs font-semibold rounded-full {{ $estadoClases }}">
                                    {{ $c->estado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('clientes.show', $c) }}"
                                       class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium hover:bg-blue-200 transition">
                                        Ver
                                    </a>
                                    <a href="{{ route('clientes.edit', $c) }}"
                                       class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-md text-xs font-medium hover:bg-yellow-200 transition">
                                        Editar
                                    </a>
                                    <form action="{{ route('clientes.destroy', $c) }}" method="POST" onsubmit="return confirm('¿Eliminar este cliente?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 bg-red-100 text-red-700 rounded-md text-xs font-medium hover:bg-red-200 transition">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $clientes->links() }}
        </div>
    @endif

</div>
@endsection