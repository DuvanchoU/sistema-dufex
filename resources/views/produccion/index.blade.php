@extends('layouts.app')

@section('title', 'Listado de Producción')

@section('content')
<div class="bg-[#F8F5F0] min-h-screen px-6 py-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Producción</h1>
        <a href="{{ route('produccion.create') }}"
           class="px-4 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-lg font-medium transition shadow-sm">
            + Nueva Producción
        </a>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Panel de Filtros Horizontal -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6">
        <form method="GET" action="{{ route('produccion.index') }}" class="flex flex-wrap items-end gap-3">

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

            <div class="flex-1 min-w-36">
                <label class="block text-xs font-medium text-gray-700">Estado</label>
                <select name="estado_produccion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
                    <option value="">Todos</option>
                    <option value="POR COMENZAR" {{ request('estado_produccion') == 'POR COMENZAR' ? 'selected' : '' }}>POR COMENZAR</option>
                    <option value="EN PROCESO" {{ request('estado_produccion') == 'EN PROCESO' ? 'selected' : '' }}>EN PROCESO</option>
                    <option value="TERMINADO" {{ request('estado_produccion') == 'TERMINADO' ? 'selected' : '' }}>TERMINADO</option>
                </select>
            </div>

            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-700">Observaciones</label>
                <input type="text" name="observaciones" value="{{ request('observaciones') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm"
                       placeholder="Ej: Falta material, prioridad alta...">
            </div>

            <div class="flex-1 min-w-32">
                <label class="block text-xs font-medium text-gray-700">Inicio</label>
                <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
            </div>

            <div class="flex-1 min-w-32">
                <label class="block text-xs font-medium text-gray-700">Fin</label>
                <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
            </div>

            <div class="flex gap-2 mt-1">
                <button type="submit" class="px-6 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-md font-medium transition">
                    Aplicar
                </button>
                <a href="{{ route('produccion.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md font-medium transition">
                    Limpiar
                </a>
            </div>

        </form>
    </div>

    {{-- Tabla --}}
    @if ($producciones->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center text-gray-500">
            No hay registros de producción que coincidan con los filtros.
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inicio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observaciones</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($producciones as $p)
                        @php
                            $estadoClases = match ($p->estado_produccion) {
                                'TERMINADO'     => 'bg-green-100 text-green-800',
                                'EN PROCESO'    => 'bg-yellow-100 text-yellow-800',
                                'POR COMENZAR'  => 'bg-gray-100 text-gray-800',
                                default         => 'bg-gray-100 text-gray-800',
                            };
                        @endphp

                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="font-medium text-gray-900">
                                    {{ $p->producto->codigo_producto }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $p->producto->referencia_producto ?? '—' }}
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $p->cantidad_producida }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $p->fecha_inicio?->format('d/m/Y') ?? '—' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $p->fecha_fin?->format('d/m/Y') ?? '—' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700 max-w-xs">
                                <div class="truncate" title="{{ $p->observaciones ?? '' }}">
                                    {{ $p->observaciones ?? '—' }}
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="inline-flex px-2.5 py-0.5 text-xs font-semibold rounded-full {{ $estadoClases }}">
                                    {{ $p->estado_produccion }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('produccion.show', $p) }}"
                                       class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium hover:bg-blue-200 transition">
                                        Ver
                                    </a>
                                    <a href="{{ route('produccion.edit', $p) }}"
                                       class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-md text-xs font-medium hover:bg-yellow-200 transition">
                                        Editar
                                    </a>
                                    <form action="{{ route('produccion.destroy', $p) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar este registro de producción?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="px-2.5 py-1 bg-red-100 text-red-700 rounded-md text-xs font-medium hover:bg-red-200 transition">
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
            {{ $producciones->links() }}
        </div>
    @endif
</div>
@endsection