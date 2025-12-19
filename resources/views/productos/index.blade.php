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
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-center">{{ session('success') }}</div>
    @endif

    <!-- Panel de Filtros Horizontal -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6">
        <form method="GET" action="{{ route('productos.index') }}" class="flex flex-wrap items-end gap-3">

            <!-- Código -->
            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-700">Código</label>
                <input type="text" name="codigo" value="{{ request('codigo') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm"
                    placeholder="Ej: BASE-001">
            </div>

            <!-- Referencia -->
            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-700">Referencia</label>
                <input type="text" name="referencia" value="{{ request('referencia') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm"
                    placeholder="Ej: Base Canoa">
            </div>

            <!-- Categoría -->
            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-700">Categoría</label>
                <select name="categoria_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
                    <option value="">Todas</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id_categorias }}" {{ request('categoria_id') == $categoria->id_categorias ? 'selected' : '' }}>
                            {{ $categoria->nombre_categoria }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tipo de Madera -->
            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-700">Tipo de Madera</label>
                <input type="text" name="tipo_madera" value="{{ request('tipo_madera') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm"
                    placeholder="Ej: Pino">
            </div>

            <!-- Color -->
            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-700">Color</label>
                <input type="text" name="color" value="{{ request('color') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm"
                    placeholder="Ej: Natural">
            </div>

            <!-- Precio Mínimo -->
            <div class="flex-1 min-w-36">
                <label class="block text-xs font-medium text-gray-700">($) Precio Mínimo</label>
                <input type="number" step="0.01" name="precio_min" value="{{ request('precio_min') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
            </div>

            <!-- Precio Máximo -->
            <div class="flex-1 min-w-36">
                <label class="block text-xs font-medium text-gray-700">($) Precio Máximo</label>
                <input type="number" step="0.01" name="precio_max" value="{{ request('precio_max') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
            </div>

            <!-- Botones -->
            <div class="flex gap-2 mt-1">
                <button type="submit" class="px-6 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-md font-medium transition">
                    Aplicar
                </button>
                <a href="{{ route('productos.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md font-medium transition">
                    Limpiar
                </a>
            </div>

        </form>
    </div>

    <!-- Tabla de Productos -->
    @if ($productos->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center text-gray-500">
            No hay productos que coincidan con los filtros.
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo Madera</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Color</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">($) Precio</th>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $producto->tipo_madera ?? '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $producto->color_producto ?? '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($producto->precio_actual, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('productos.show', $producto) }}" 
                                    class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium hover:bg-blue-200 transition">Ver</a>
                                    <a href="{{ route('productos.edit', $producto) }}" 
                                    class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-md text-xs font-medium hover:bg-yellow-200 transition">Editar</a>
                                    <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este producto?')">
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