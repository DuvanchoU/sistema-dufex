@extends('layouts.tienda')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Nuestros Productos</h1>

        <!-- Categorías -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            @foreach($categorias as $categoria)
                <a href="{{ route('tienda.categoria', $categoria) }}"
                class="block p-4 bg-gray-50 rounded-lg text-center hover:bg-gray-100 transition">
                    <span class="text-lg font-medium">{{ $categoria->nombre_categoria }}</span>
                </a>
            @endforeach
        </div>

        <!-- Productos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($productos as $producto)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <img src="{{ $producto->imagen_principal }}" 
                        alt="{{ $producto->referencia_producto }}" 
                        class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900">{{ $producto->referencia_producto }}</h3>
                        <p class="text-gray-600 text-sm">{{ $producto->categoria->nombre ?? '' }}</p>
                        <p class="mt-2 text-xl font-bold text-gray-900">${{ number_format($producto->precio_actual, 0, ',', '.') }}</p>
                        <a href="{{ route('tienda.producto', $producto) }}"
                           class="mt-4 inline-block px-4 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-md text-sm">
                            Ver Producto
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $productos->links() }}
    </div>
</div>
@endsection