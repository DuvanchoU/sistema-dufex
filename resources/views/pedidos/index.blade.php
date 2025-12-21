@extends('layouts.app')

@section('title', 'Listado de Pedidos')

@section('content')
<div class="bg-[#F8F5F0] min-h-screen px-6 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Pedidos</h1>
        <a href="{{ route('pedidos.create') }}" 
           class="px-4 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-lg font-medium transition shadow-sm">
            + Nuevo Pedido
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-center">{{ session('success') }}</div>
    @endif

    <!-- Panel de Filtros Horizontal -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6">
        <form method="GET" action="{{ route('pedidos.index') }}" class="flex flex-wrap items-end gap-3">

            <div class="flex-1 min-w-40">
                <label class="block text-xs font-medium text-gray-700">Usuario</label>
                <select name="usuario_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
                    <option value="">Todos</option>
                    @foreach($usuarios as $u)
                        <option value="{{ $u->id_usuario }}" {{ request('usuario_id') == $u->id_usuario ? 'selected' : '' }}>
                            {{ $u->nombres }}
                        </option>
                    @endforeach
                </select>
            </div>

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

            <div class="flex-1 min-w-36">
                <label class="block text-xs font-medium text-gray-700">Estado</label>
                <select name="estado_pedido" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
                    <option value="">Todos</option>
                    <option value="PENDIENTE" {{ request('estado_pedido') == 'PENDIENTE' ? 'selected' : '' }}>PENDIENTE</option>
                    <option value="EN PROCESO" {{ request('estado_pedido') == 'EN PROCESO' ? 'selected' : '' }}>EN PROCESO</option>
                    <option value="ENTREGADO" {{ request('estado_pedido') == 'ENTREGADO' ? 'selected' : '' }}>ENTREGADO</option>
                    <option value="CANCELADO" {{ request('estado_pedido') == 'CANCELADO' ? 'selected' : '' }}>CANCELADO</option>
                </select>
            </div>

            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-700">Dirección Entrega</label>
                <input type="text" name="direccion_entrega" value="{{ request('direccion_entrega') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm"
                       placeholder="Ej: Calle 80 #71-40">
            </div>

            <div class="flex-1 min-w-32">
                <label class="block text-xs font-medium text-gray-700">Pedido</label>
                <input type="date" name="fecha_pedido" value="{{ request('fecha_pedido') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
            </div>

            <div class="flex-1 min-w-32">
                <label class="block text-xs font-medium text-gray-700">Entrega</label>
                <input type="date" name="fecha_entrega" value="{{ request('fecha_entrega') }}"
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
                <a href="{{ route('pedidos.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md font-medium transition">
                    Limpiar
                </a>
            </div>

        </form>
    </div>

    @if ($pedidos->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center text-gray-500">
            No hay pedidos que coincidan con los filtros.
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Pedido</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entrega Estimada</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dirección Entrega</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total ($)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($pedidos as $pedido)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pedido->id_pedido }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $pedido->usuario?->nombres ?? '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $pedido->cliente?->nombre ?? '—' }} {{ $pedido->cliente?->apellido ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $pedido->fecha_pedido ? \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y H:i') : '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $pedido->fecha_entrega_estimada ? \Carbon\Carbon::parse($pedido->fecha_entrega_estimada)->format('d/m/Y') : '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $pedido->direccion_entrega ?? '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($pedido->total_pedido, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($pedido->estado_pedido)
                                    @case('PENDIENTE')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">PENDIENTE</span>
                                        @break
                                    @case('EN PROCESO')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">EN PROCESO</span>
                                        @break
                                    @case('ENTREGADO')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">ENTREGADO</span>
                                        @break
                                    @case('CANCELADO')
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">CANCELADO</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('pedidos.show', $pedido) }}" 
                                       class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium hover:bg-blue-200 transition">Ver</a>
                                    <a href="{{ route('pedidos.edit', $pedido) }}" 
                                       class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-md text-xs font-medium hover:bg-yellow-200 transition">Editar</a>
                                    <form action="{{ route('pedidos.destroy', $pedido) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este pedido? Se eliminará lógicamente.')">
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
        <div class="mt-6">{{ $pedidos->links() }}</div>
    @endif
</div>
@endsection