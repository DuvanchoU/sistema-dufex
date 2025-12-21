@extends('layouts.tienda')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Tu Carrito</h1>

        @if($carrito->items->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500">Tu carrito está vacío.</p>
                <a href="{{ route('tienda.index') }}" class="mt-4 inline-block px-4 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-md">
                    Seguir Comprando
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($carrito->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img src="{{ $item->producto->imagen_url ?? asset('images/default-product.jpg') }}"
                                                 alt="{{ $item->producto->referencia_producto }}"
                                                 class="h-10 w-10 rounded">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $item->producto->referencia_producto }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ${{ number_format($item->precio_unitario, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('carrito.actualizar', $item->id_item) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="number" name="cantidad" value="{{ $item->cantidad }}"
                                                   min="1" max="99" class="w-16 text-center border rounded">
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ${{ number_format($item->total_linea, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <form action="{{ route('carrito.eliminar', $item->id_item) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold mb-4">Resumen</h2>
                    <div class="space-y-2 mb-6">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>${{ number_format($carrito->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Impuestos (19%)</span>
                            <span>${{ number_format($carrito->total * 0.19, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t pt-2 flex justify-between font-bold">
                            <span>Total</span>
                            <span>${{ number_format($carrito->total * 1.19, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}"
                       class="w-full block px-6 py-3 bg-[#CBB8A0] hover:bg-[#B9A489] text-white font-medium rounded-md text-center">
                        Proceder al Pago
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection