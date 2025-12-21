@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-sm border border-gray-200">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Producto</h1>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.update', $producto->id_producto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label for="codigo_producto" class="block text-sm font-medium text-gray-700 mb-1">Código del Producto *</label>
            <input
                type="text"
                name="codigo_producto"
                id="codigo_producto"
                value="{{ old('codigo_producto', $producto->codigo_producto) }}"
                class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
                required
            >
        </div>

        <div class="mb-5">
            <label for="referencia_producto" class="block text-sm font-medium text-gray-700 mb-1">Referencia</label>
            <input
                type="text"
                name="referencia_producto"
                id="referencia_producto"
                value="{{ old('referencia_producto', $producto->referencia_producto) }}"
                class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
            >
        </div>

        <div class="mb-5">
            <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
            <select
                name="categoria_id"
                id="categoria_id"
                class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
                required
            >
                <option value="">-- Seleccione una categoría --</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id_categorias }}" 
                        {{ (old('categoria_id', $producto->categoria_id) == $categoria->id_categorias) ? 'selected' : '' }}>
                        {{ $categoria->nombre_categoria }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-5">
            <label for="tipo_madera" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Madera</label>
            <input
                type="text"
                name="tipo_madera"
                id="tipo_madera"
                value="{{ old('tipo_madera', $producto->tipo_madera) }}"
                class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
            >
        </div>

        <div class="mb-5">
            <label for="color_producto" class="block text-sm font-medium text-gray-700 mb-1">Color (opcional)</label>
            <input
                type="text"
                name="color_producto"
                id="color_producto"
                value="{{ old('color_producto', $producto->color_producto) }}"
                class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
            >
        </div>

        <div class="mb-6">
            <label for="precio_actual" class="block text-sm font-medium text-gray-700 mb-1">($) Precio Actual *</label>
            <input
                type="number"
                step="0.01"
                name="precio_actual"
                id="precio_actual"
                value="{{ old('precio_actual', $producto->precio_actual) }}"
                class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-marron-oscuro focus:border-marron-oscuro"
                min="0"
                required
            >
        </div>

        <!-- Imágenes existentes -->
        @if($producto->imagenes->count())
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Imágenes actuales</label>
                <div class="grid grid-cols-3 gap-2">
                    @foreach($producto->imagenes as $imagen)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $imagen->ruta_imagen) }}" class="h-24 object-cover rounded">
                            <span class="absolute bottom-0 left-0 bg-black bg-opacity-50 text-white text-xs px-1">{{ $imagen->descripcion ?? 'Sin descripción' }}</span>
                            @if($imagen->es_principal)
                                <span class="absolute top-0 right-0 bg-yellow-500 text-white text-xs px-1">Principal</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Nuevas imágenes -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Reemplazar imagen principal</label>
            <input type="file" name="imagenes" accept="image/*" class="block w-full">
            <input type="text" name="descripcion_imagen" placeholder="Descripción (opcional)" class="mt-2 w-full border rounded px-2">
            <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG (máx. 2MB)</p>
        </div>

        <script>
        function agregarImagen() {
            const container = document.getElementById('imagenes-container');
            const div = document.createElement('div');
            div.className = 'flex items-center mb-2';
            div.innerHTML = `
                <input type="file" name="imagenes" accept="image/*" class="mr-2">
                <input type="text" name="descripcion_imagen" placeholder="Descripción (opcional)" class="flex-1 mr-2 border rounded px-2">
                <button type="button" onclick="this.parentElement.remove()" class="bg-red-500 text-white px-2 rounded">-</button>
            `;
            container.appendChild(div);
        }
        </script>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('productos.index') }}" 
               class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md font-medium hover:bg-gray-300 transition">Cancelar</a>
            <button type="submit" 
                    class="px-4 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-lg font-medium transition shadow-sm">
                Actualizar Producto
            </button>
        </div>
    </form>
</div>
@endsection