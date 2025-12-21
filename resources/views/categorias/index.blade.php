@extends('layouts.app')

@section('title', 'Listado de Categorías')

@section('content')
<div class="bg-[#F8F5F0] min-h-screen px-6 py-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Categorías</h1>
        <a href="{{ route('categorias.create') }}" 
           class="px-4 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-lg font-medium transition shadow-sm">
            + Nueva Categoría
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-center">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">{{ $errors->first() }}</div>
    @endif

    <!-- Panel de Filtros Horizontal -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6">
        <form method="GET" action="{{ route('categorias.index') }}" class="flex flex-wrap items-end gap-3">

            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre_categoria" value="{{ request('nombre_categoria') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm"
                       placeholder="Ej: Muebles de Oficina">
            </div>

            <div class="flex-1 min-w-36">
                <label class="block text-xs font-medium text-gray-700">Estado</label>
                <select name="estado_categoria" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
                    <option value="">Todos</option>
                    <option value="activo" {{ request('estado_categoria') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ request('estado_categoria') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="flex gap-2 mt-1">
                <button type="submit" class="px-6 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-md font-medium transition">
                    Aplicar
                </button>
                <a href="{{ route('categorias.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md font-medium transition">
                    Limpiar
                </a>
            </div>

        </form>
    </div>

    @if ($categorias->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow-sm text-center text-gray-500">
            No hay categorías que coincidan con los filtros.
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Productos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($categorias as $categoria)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $categoria->nombre_categoria }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2.5 py-0.5 inline-flex text-xs font-semibold rounded-full 
                                    {{ $categoria->estado_categoria === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ strtoupper($categoria->estado_categoria) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $categoria->productos_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('categorias.show', $categoria) }}" 
                                       class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium hover:bg-blue-200 transition">Ver</a>
                                    <a href="{{ route('categorias.edit', $categoria) }}" 
                                       class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-md text-xs font-medium hover:bg-yellow-200 transition">Editar</a>
                                    <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="inline" onsubmit="return confirm('¿Desactivar esta categoría?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 bg-red-100 text-red-700 rounded-md text-xs font-medium hover:bg-red-200 transition">Desactivar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $categorias->links() }}</div>
    @endif
</div>
@endsection