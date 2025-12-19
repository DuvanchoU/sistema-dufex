@extends('layouts.app')

@section('title', 'Listado de Ventas')

@section('content')
<div class="bg-[#F8F5F0] min-h-screen px-6 py-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Ventas</h1>
        <a href="{{ route('ventas.create') }}"
           class="px-4 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-lg font-medium transition shadow-sm">
            + Nueva Venta
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
        <form method="GET" action="{{ route('ventas.index') }}" class="flex flex-wrap items-end gap-3">

            <div class="flex-1 min-w-40">
                <label class="block text-xs font-medium text-gray-700">Cliente</label>
                <select name="cliente_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
                    <option value="">Todos</option>
                    @foreach($clientes as $c)
                        <option value="{{ $c->id_cliente }}" {{ request('cliente_id') == $c->id_cliente ? 'selected' : '' }}>
                            {{ $c->nombre }} {{ $c->apellido ?? '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-40">
                <label class="block text-xs font-medium text-gray-700">Vendedor</label>
                <select name="usuario_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
                    <option value="">Todos</option>
                    @foreach($usuarios as $u)
                        <option value="{{ $u->id_usuario }}" {{ request('usuario_id') == $u->id_usuario ? 'selected' : '' }}>
                            {{ $u->nombres }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-36">
                <label class="block text-xs font-medium text-gray-700">Método de Pago</label>
                <select name="metodo_pago_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
                    <option value="">Todos</option>
                    @foreach($metodosPago as $mp)
                        <option value="{{ $mp->id_metodo }}" {{ request('metodo_pago_id') == $mp->id_metodo ? 'selected' : '' }}>
                            {{ $mp->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-32">
                <label class="block text-xs font-medium text-gray-700">Estado</label>
                <select name="estado_venta" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
                    <option value="">Todos</option>
                    <option value="COMPLETADA" {{ request('estado_venta') == 'COMPLETADA' ? 'selected' : '' }}>COMPLETADA</option>
                    <option value="PENDIENTE" {{ request('estado_venta') == 'PENDIENTE' ? 'selected' : '' }}>PENDIENTE</option>
                    <option value="CANCELADA" {{ request('estado_venta') == 'CANCELADA' ? 'selected' : '' }}>CANCELADA</option>
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
                <label class="block text-xs font-medium text-gray-700">Total Mín ($)</label>
                <input type="number" step="0.01" name="total_min" value="{{ request('total_min') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
            </div>

            <div class="flex-1 min-w-28">
                <label class="block text-xs font-medium text-gray-700">Total Máx ($)</label>
                <input type="number" step="0.01" name="total_max" value="{{ request('total_max') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
            </div>

            <div class="flex gap-2 mt-1">
                <button type="submit" class="px-6 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-md font-medium transition">
                    Aplicar
                </button>
                <a href="{{ route('ventas.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md font-medium transition">
                    Limpiar
                </a>
            </div>

        </form>
    </div>

    {{-- Tabla --}}
    @if ($ventas->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center text-gray-500">
            No hay ventas que coincidan con los filtros.
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendedor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Método Pago</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($ventas as $v)
                        @php
                            $estadoClases = match ($v->estado_venta) {
                                'COMPLETADA'   => 'bg-green-100 text-green-800',
                                'PENDIENTE'    => 'bg-yellow-100 text-yellow-800',
                                'CANCELADA'    => 'bg-red-100 text-red-800',
                                default        => 'bg-gray-100 text-gray-800',
                            };
                        @endphp

                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $v->fecha_venta?->format('d/m/Y H:i') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $v->cliente?->nombre ?? '—' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $v->usuario->nombres ?? '—' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $v->metodoPago?->nombre ?? '—' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                ${{ number_format($v->total_venta, 2, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="inline-flex px-2.5 py-0.5 text-xs font-semibold rounded-full {{ $estadoClases }}">
                                    {{ $v->estado_venta }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('ventas.show', $v) }}"
                                       class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium hover:bg-blue-200 transition">
                                        Ver
                                    </a>
                                    <form action="{{ route('ventas.destroy', $v) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Eliminar esta venta? Esta acción es irreversible.')">
                                        @csrf
                                        @method('DELETE')
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
            {{ $ventas->links() }}
        </div>
    @endif
</div>
@endsection