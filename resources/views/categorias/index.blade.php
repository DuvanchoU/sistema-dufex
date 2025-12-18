@extends('layouts.app')

@section('title', 'Listado de Categorías')

@section('content')
<div class="bg-[#F8F5F0] min-h-screen px-6 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Categorías</h1>
        <a href="{{ route('categorias.create') }}" 
           class="px-4 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-lg font-medium transition shadow-sm">
            + Nueva Categoría
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">{{ $errors->first() }}</div>
    @endif

    @if ($categorias->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow-sm text-center text-gray-500">
            No hay categorías registradas.
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
                                    {{ ucfirst($categoria->estado_categoria) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $categoria->productos_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('categorias.show', $categoria->id_categorias) }}" 
                                       class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium hover:bg-blue-200 transition">Ver</a>
                                    <a href="{{ route('categorias.edit', $categoria->id_categorias) }}" 
                                       class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-md text-xs font-medium hover:bg-yellow-200 transition">Editar</a>
                                    <form action="{{ route('categorias.destroy', $categoria->id_categorias) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar esta categoría?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 bg-red-100 text-red-700 rounded-md text-xs font-medium hover:bg-red-200 transition">Eliminar</button>
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