<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductoController extends Controller
{   
    // Muestra una lista paginada de productos con su categoría.
    public function index(Request $request): View
    {
        $query = Producto::with('categoria');

        // Filtros
        if ($request->filled('codigo')) {
            $query->where('codigo_producto', 'LIKE', '%' . $request->codigo . '%');
        }

        if ($request->filled('referencia')) {
            $query->where('referencia_producto', 'LIKE', '%' . $request->referencia . '%');
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('precio_min')) {
            $query->where('precio_actual', '>=', $request->precio_min);
        }

        if ($request->filled('precio_max')) {
            $query->where('precio_actual', '<=', $request->precio_max);
        }

        if ($request->filled('tipo_madera')) {
            $query->where('tipo_madera', 'LIKE', '%' . $request->tipo_madera . '%');
        }

        if ($request->filled('color')) {
            $query->where('color_producto', 'LIKE', '%' . $request->color . '%');
        }

        // Ordenar alfabéticamente
        $query->orderBy('codigo_producto', 'ASC');

        $productos = $query->paginate(15)->appends($request->query());
        $categorias = Categoria::all(['id_categorias', 'nombre_categoria']);

        return view('productos.index', compact('productos', 'categorias'));
    }

    public function create(): View
    {
        $categorias = Categoria::all(['id_categorias', 'nombre_categoria']);
        return view('productos.create', compact('categorias'));
    }

    // Almacena un nuevo producto en la base de datos.
    public function store(StoreProductoRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        // Eliminar campos de imágenes del array principal (si los agregaste a las reglas)
        unset($data['imagenes'], $data['descripcion_imagen']);

        $producto = Producto::create($data);

        // Procesar múltiples imágenes
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $index => $file) {
                $path = $file->store('productos', 'public');
                $producto->imagenes()->create([
                    'ruta_imagen' => $path,
                    'descripcion' => $request->descripcion_imagen[$index] ?? null,
                    'es_principal' => ($index === 0) // la primera es principal
                ]);
            }
        }

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    // Muestra los detalles de un producto específico.
    public function show(Producto $producto): View
    {
        $producto->load('categoria');
        return view('productos.show', compact('producto'));
    }

    // Muestra el formulario para editar un producto existente.
    public function edit(Producto $producto): View
    {   
        $producto->load('imagenes'); // Carga las imágenes aquí
        $categorias = Categoria::all(['id_categorias', 'nombre_categoria']);
        return view('productos.edit', compact('producto', 'categorias'));
    }

    // Actualiza un producto existente en la base de datos.
    public function update(UpdateProductoRequest $request, Producto $producto): RedirectResponse
    {
        $data = $request->validated();

        // Eliminar campos de imágenes del array principal
        unset($data['imagenes'], $data['descripcion_imagen']);

        $producto->update($data);

        // Si se sube una nueva imagen
        if ($request->hasFile('imagenes')) {
            // Eliminar imagen anterior
            if ($producto->imagenes->isNotEmpty()) {
                $imagenAnterior = $producto->imagenes->first();
                Storage::disk('public')->delete($imagenAnterior->ruta_imagen);
                $imagenAnterior->delete();
            }

            // Guardar nueva imagen
            $path = $request->file('imagenes')->store('productos', 'public');
            $producto->imagenes()->create([
                'ruta_imagen' => $path,
                'descripcion' => $request->descripcion_imagen,
                'es_principal' => true
            ]);
        }

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    // Desactiva un producto de la base de datos.
    public function destroy(Producto $producto): RedirectResponse
    {
        $producto->delete(); // Esto hace soft delete gracias a SoftDeletes
        return redirect()->route('productos.index')
                        ->with('success', 'Producto dado de baja exitosamente.');
    }
    
}