@extends('layouts.tienda')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <!-- Imagen principal -->
                <img id="imagen-principal" src="{{ $producto->imagen_principal }}" 
                    alt="{{ $producto->referencia_producto }}" 
                    class="w-full rounded-lg">

                <!-- Galería -->
                @if($producto->imagenes->count() > 1)
                    <div class="grid grid-cols-4 gap-2 mt-4">
                        @foreach($producto->imagenes as $imagen)
                            <img src="{{ asset('storage/' . $imagen->ruta_imagen) }}" 
                                class="h-20 object-cover rounded cursor-pointer border-2 border-transparent"
                                onclick="cambiarImagenPrincipal('{{ asset('storage/' . $imagen->ruta_imagen) }}')">
                        @endforeach
                    </div>
                @endif

                <script>
                function cambiarImagenPrincipal(src) {
                    document.getElementById('imagen-principal').src = src;
                }
                </script>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $producto->referencia_producto }}</h1>
                <p class="text-gray-600 mb-4">{{ $producto->categoria->nombre ?? '' }}</p>
                <p class="text-3xl font-bold text-gray-900 mb-4">${{ number_format($producto->precio_actual, 0, ',', '.') }}</p>

                <form action="{{ route('tienda.carrito.agregar', $producto->id_producto) }}" method="POST">
                    @csrf
                    <div class="flex items-center mb-6">
                        <button type="button" class="decrement-btn px-3 py-1 border rounded-l">-</button>
                        <input type="number" name="cantidad" value="1" min="1" max="99"
                               class="w-16 text-center border-t border-b">
                        <button type="button" class="increment-btn px-3 py-1 border rounded-r">+</button>
                    </div>

                    <button type="submit"
                            class="w-full px-6 py-3 bg-[#CBB8A0] hover:bg-[#B9A489] text-white font-medium rounded-md transition">
                        Agregar al Carrito
                    </button>
                </form>

                <div class="mt-6">
                    <h3 class="font-semibold">Descripción</h3>
                    <p class="mt-2 text-gray-700">{{ $producto->descripcion ?? 'Sin descripción.' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection