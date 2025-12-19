<?php

namespace App\Http\Controllers;

use App\Models\Produccion;
use App\Models\Producto;
use App\Http\Requests\StoreProduccionRequest;
use App\Http\Requests\UpdateProduccionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProduccionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Produccion::with('producto');

        // Filtros
        if ($request->filled('producto_id')) {
            $query->where('producto_id', $request->producto_id);
        }

        if ($request->filled('estado_produccion')) {
            $query->where('estado_produccion', $request->estado_produccion);
        }

        if ($request->filled('observaciones')) {
            $query->where('observaciones', 'LIKE', '%' . $request->observaciones . '%');
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_inicio', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_fin', '<=', $request->fecha_fin);
        }

        $producciones = $query->orderBy('fecha_inicio', 'desc')
                            ->paginate(15)
                            ->appends($request->query());

        $productos = Producto::all(['id_producto', 'codigo_producto', 'referencia_producto']);

        return view('produccion.index', compact('producciones', 'productos'));
    }

    public function create(): View
    {
        $productos = Producto::all(['id_producto', 'codigo_producto', 'referencia_producto']);
        return view('produccion.create', compact('productos'));
    }

    public function store(StoreProduccionRequest $request): RedirectResponse
    {
        Produccion::create($request->validated());
        return redirect()->route('produccion.index')
            ->with('success', 'Registro de producción creado exitosamente.');
    }

    public function show(Produccion $produccion): View
    {
        $produccion->load('producto');
        return view('produccion.show', compact('produccion'));
    }

    public function edit(Produccion $produccion): View
    {
        $productos = Producto::all(['id_producto', 'codigo_producto', 'referencia_producto']);
        return view('produccion.edit', compact('produccion', 'productos'));
    }

    public function update(UpdateProduccionRequest $request, Produccion $produccion): RedirectResponse
    {
        $produccion->update($request->validated());
        return redirect()->route('produccion.index')
            ->with('success', 'Registro de producción actualizado exitosamente.');
    }

    public function destroy(Produccion $produccion): RedirectResponse
    {
        $produccion->delete(); // Soft delete
        return redirect()->route('produccion.index')
            ->with('success', 'Registro de producción dado de baja exitosamente.');
    }
}
