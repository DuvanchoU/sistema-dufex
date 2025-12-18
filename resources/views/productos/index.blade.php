@extends('layouts.app')

@section('title', 'Listado de Productos')

@section('content')
<div class="bg-[#F8F5F0] min-h-screen px-6 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Productos</h1>
        <a href="{{ route('productos.create') }}" 
           class="px-4 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-lg font-medium transition shadow-sm">
            + Nuevo Producto
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
    @endif

    @if ($productos->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center text-gray-500">
            No hay productos registrados.
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referencia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio ($)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($productos as $producto)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $producto->id_producto }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $producto->codigo_producto }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $producto->referencia_producto ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $producto->categoria?->nombre_categoria ?? 'Sin categoría' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($producto->precio_actual, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('productos.show', $producto->id_producto) }}" 
                                       class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium hover:bg-blue-200 transition">Ver</a>
                                    <a href="{{ route('productos.edit', $producto->id_producto) }}" 
                                       class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-md text-xs font-medium hover:bg-yellow-200 transition">Editar</a>
                                    <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este producto?')">
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
        <div class="mt-6">{{ $productos->links() }}</div>
    @endif
</div>
@endsection