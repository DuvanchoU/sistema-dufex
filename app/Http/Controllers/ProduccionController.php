<?php

namespace App\Http\Controllers;

use App\Models\Produccion;
use App\Models\Producto;
use App\Http\Requests\StoreProduccionRequest;
use App\Http\Requests\UpdateProduccionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProduccionController extends Controller
{
    public function index(): View
    {
        $producciones = Produccion::with('producto')
            ->orderBy('fecha_inicio', 'desc')
            ->paginate(15);
        return view('produccion.index', compact('producciones'));
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
