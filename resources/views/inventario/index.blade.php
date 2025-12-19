@extends('layouts.app')

@section('title', 'Gestión de Inventario')

@section('content')
<div class="bg-[#F8F5F0] min-h-screen px-6 py-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Inventario</h1>
        <a href="{{ route('inventario.create') }}"
           class="px-4 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-lg font-medium transition shadow-sm">
            + Nuevo Registro
        </a>
    </div>

    {{-- Mensaje --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Panel de Filtros Horizontal -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6">
        <form method="GET" action="{{ route('inventario.index') }}" class="flex flex-wrap items-end gap-3">

            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-700">Producto</label>
                <select name="producto_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
                    <option value="">Todos</option>
                    @foreach($productos as $p)
                        <option value="{{ $p->id_producto }}" {{ request('producto_id') == $p->id_producto ? 'selected' : '' }}>
                            {{ $p->codigo_producto }} — {{ $p->referencia_producto ?? 'Sin ref.' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-700">Bodega</label>
                <select name="bodega_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
                    <option value="">Todas</option>
                    @foreach($bodegas as $b)
                        <option value="{{ $b->id_bodega }}" {{ request('bodega_id') == $b->id_bodega ? 'selected' : '' }}>
                            {{ $b->nombre_bodega }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-700">Proveedor</label>
                <select name="proveedor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
                    <option value="">Todos</option>
                    @foreach($proveedores as $prov)
                        <option value="{{ $prov->id_proveedor }}" {{ request('proveedor_id') == $prov->id_proveedor ? 'selected' : '' }}>
                            {{ $prov->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-32">
                <label class="block text-xs font-medium text-gray-700">Estado</label>
                <select name="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
                    <option value="">Todos</option>
                    <option value="DISPONIBLE" {{ request('estado') == 'DISPONIBLE' ? 'selected' : '' }}>DISPONIBLE</option>
                    <option value="COMPROMETIDO" {{ request('estado') == 'COMPROMETIDO' ? 'selected' : '' }}>COMPROMETIDO</option>
                    <option value="AGOTADO" {{ request('estado') == 'AGOTADO' ? 'selected' : '' }}>AGOTADO</option>
                </select>
            </div>

            <div class="flex-1 min-w-32">
                <label class="block text-xs font-medium text-gray-700">Desde</label>
                <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
            </div>

            <div class="flex-1 min-w-32">
                <label class="block text-xs font-medium text-gray-700">Hasta</label>
                <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
            </div>

            <div class="flex-1 min-w-28">
                <label class="block text-xs font-medium text-gray-700">Cant. Mín</label>
                <input type="number" name="cantidad_min" value="{{ request('cantidad_min') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
            </div>

            <div class="flex-1 min-w-28">
                <label class="block text-xs font-medium text-gray-700">Cant. Máx</label>
                <input type="number" name="cantidad_max" value="{{ request('cantidad_max') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
            </div>

            <div class="flex gap-2 mt-1">
                <button type="submit" class="px-6 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-md font-medium transition">
                    Aplicar
                </button>
                <a href="{{ route('inventario.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md font-medium transition">
                    Limpiar
                </a>
            </div>

        </form>
    </div>

    {{-- Tabla --}}
    @if ($inventarios->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center text-gray-500">
            No hay registros de inventario que coincidan con los filtros.
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bodega</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Proveedor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Llegada</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($inventarios as $inv)
                        @php
                            $estadoClases = match($inv->estado) {
                                'DISPONIBLE' => 'bg-green-100 text-green-800',
                                'COMPROMETIDO' => 'bg-yellow-100 text-yellow-800',
                                default => 'bg-red-100 text-red-800'
                            };
                        @endphp

                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm">
                                <div class="font-medium text-gray-900">
                                    {{ $inv->producto->codigo_producto }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $inv->producto->referencia_producto ?? 'Sin referencia' }}
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $inv->bodega->nombre_bodega ?? 'Sin bodega' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $inv->proveedor->nombre ?? 'Sin proveedor' }}
                            </td>

                            <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                {{ $inv->cantidad_disponible }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $inv->fecha_llegada?->format('d/m/Y') ?? '—' }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                <span class="px-2.5 py-0.5 inline-flex text-xs font-semibold rounded-full {{ $estadoClases }}">
                                    {{ $inv->estado }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('inventario.show', $inv) }}"
                                       class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium hover:bg-blue-200 transition">
                                        Ver
                                    </a>
                                    <a href="{{ route('inventario.edit', $inv) }}"
                                       class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-md text-xs font-medium hover:bg-yellow-200 transition">
                                        Editar
                                    </a>
                                    <form action="{{ route('inventario.destroy', $inv) }}" method="POST" onsubmit="return confirm('¿Eliminar este registro de inventario?')">
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
            {{ $inventarios->links() }}
        </div>
    @endif

</div>
@endsection