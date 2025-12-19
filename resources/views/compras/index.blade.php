@extends('layouts.app')

@section('title', 'Listado de Compras')

@section('content')
<div class="bg-[#F8F5F0] min-h-screen px-6 py-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Compras</h1>
        <a href="{{ route('compras.create') }}"
           class="px-4 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-lg font-medium transition shadow-sm">
            + Nueva Compra
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
        <form method="GET" action="{{ route('compras.index') }}" class="flex flex-wrap items-end gap-3">

            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-700">Proveedor</label>
                <select name="proveedor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
                    <option value="">Todos</option>
                    @foreach($proveedores as $p)
                        <option value="{{ $p->id_proveedor }}" {{ request('proveedor_id') == $p->id_proveedor ? 'selected' : '' }}>
                            {{ $p->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-45">
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

            <div class="flex-1 min-w-36">
                <label class="block text-xs font-medium text-gray-700">Estado</label>
                <select name="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
                    <option value="">Todos</option>
                    <option value="RECIBIDA" {{ request('estado') == 'RECIBIDA' ? 'selected' : '' }}>RECIBIDA</option>
                    <option value="PENDIENTE" {{ request('estado') == 'PENDIENTE' ? 'selected' : '' }}>PENDIENTE</option>
                    <option value="CANCELADA" {{ request('estado') == 'CANCELADA' ? 'selected' : '' }}>CANCELADA</option>
                </select>
            </div>

            <div class="flex-1 min-w-40">
                <label class="block text-xs font-medium text-gray-700">Método de Pago</label>
                <select name="metodo_pago" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
                    <option value="">Todos</option>
                    <option value="EFECTIVO" {{ request('metodo_pago') == 'EFECTIVO' ? 'selected' : '' }}>EFECTIVO</option>
                    <option value="TRANSFERENCIA" {{ request('metodo_pago') == 'TRANSFERENCIA' ? 'selected' : '' }}>TRANSFERENCIA</option>
                    <option value="TARJETA DE CRÉDITO" {{ request('metodo_pago') == 'TARJETA DE CRÉDITO' ? 'selected' : '' }}>TARJETA DE CRÉDITO</option>
                    <option value="TARJETA DÉBITO" {{ request('metodo_pago') == 'TARJETA DÉBITO' ? 'selected' : '' }}>TARJETA DÉBITO</option>
                    <option value="PSE" {{ request('metodo_pago') == 'PSE' ? 'selected' : '' }}>PSE</option>
                </select>
            </div>

            <div class="flex-1 min-w-36">
                <label class="block text-xs font-medium text-gray-700">Desde</label>
                <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
            </div>

            <div class="flex-1 min-w-36">
                <label class="block text-xs font-medium text-gray-700">Hasta</label>
                <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
            </div>

            <div class="flex-1 min-w-32">
                <label class="block text-xs font-medium text-gray-700">($) Total Mínimo</label>
                <input type="number" step="0.01" name="total_min" value="{{ request('total_min') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
            </div>

            <div class="flex-1 min-w-32">
                <label class="block text-xs font-medium text-gray-700">($) Total Máximo</label>
                <input type="number" step="0.01" name="total_max" value="{{ request('total_max') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#CBB8A0] focus:ring-[#CBB8A0] sm:text-sm">
            </div>

            <div class="flex gap-2 mt-1">
                <button type="submit" class="px-6 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-md font-medium transition">
                    Aplicar
                </button>
                <a href="{{ route('compras.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md font-medium transition">
                    Limpiar
                </a>
            </div>

        </form>
    </div>

    {{-- Sin registros --}}
    @if ($compras->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center text-gray-500">
            No hay registros de compras que coincidan con los filtros.
        </div>
    @else

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proveedor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">($) Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Método Pago</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($compras as $compra)

                        @php
                            $estadoClases = match ($compra->estado) {
                                'RECIBIDA'   => 'bg-green-100 text-green-800',
                                'PENDIENTE'  => 'bg-yellow-100 text-yellow-800',
                                'CANCELADA'  => 'bg-red-100 text-red-800',
                                default      => 'bg-gray-100 text-gray-800',
                            };
                        @endphp

                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $compra->proveedor?->nombre ?? '—' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $compra->fecha_compra?->format('d/m/Y') ?? '—' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ number_format($compra->total_compra, 2, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $compra->metodo_pago ?? '—' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $compra->usuario?->nombres ?? '—' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="inline-flex px-2.5 py-0.5 text-xs font-semibold rounded-full {{ $estadoClases }}">
                                    {{ $compra->estado }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('compras.show', $compra) }}"
                                       class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium hover:bg-blue-200 transition">
                                        Ver
                                    </a>
                                    <a href="{{ route('compras.edit', $compra) }}"
                                       class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-md text-xs font-medium hover:bg-yellow-200 transition">
                                        Editar
                                    </a>
                                    <form action="{{ route('compras.destroy', $compra) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar esta compra? Se eliminará lógicamente.')">
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
            {{ $compras->links() }}
        </div>

    @endif
</div>
@endsection