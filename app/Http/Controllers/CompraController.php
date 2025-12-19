<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Usuario;
use App\Http\Requests\StoreCompraRequest;
use App\Http\Requests\UpdateCompraRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompraController extends Controller
{
    public function index(Request $request): View
    {
        $query = Compra::with(['proveedor', 'usuario']);

        // Filtros
        if ($request->filled('proveedor_id')) {
            $query->where('proveedor_id', $request->proveedor_id);
        }

        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('metodo_pago')) {
            $query->where('metodo_pago', $request->metodo_pago);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_compra', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_compra', '<=', $request->fecha_hasta);
        }

        if ($request->filled('total_min')) {
            $query->where('total_compra', '>=', $request->total_min);
        }

        if ($request->filled('total_max')) {
            $query->where('total_compra', '<=', $request->total_max);
        }

        $compras = $query->paginate(15)->appends($request->query());

        // Cargar listas para los selects
        $proveedores = Proveedor::all(['id_proveedor', 'nombre']);
        $usuarios = Usuario::all(['id_usuario', 'nombres']);

        return view('compras.index', compact('compras', 'proveedores', 'usuarios'));
    }

    public function create(): View
    {
        $proveedores = Proveedor::all(['id_proveedor', 'nombre']);
        $usuarios = Usuario::all(['id_usuario', 'nombres']);
        return view('compras.create', compact('proveedores', 'usuarios'));
    }

    public function store(StoreCompraRequest $request): RedirectResponse
    {
        Compra::create($request->validated());
        return redirect()->route('compras.index')->with('success', 'Compra creada exitosamente.');
    }

    public function show(Compra $compra): View
    {
        $compra->load(['proveedor', 'usuario', 'detalles.producto']);
        return view('compras.show', compact('compra'));
    }

    public function edit(Compra $compra): View
    {
        $proveedores = Proveedor::all(['id_proveedor', 'nombre']);
        $usuarios = Usuario::all(['id_usuario', 'nombres']);
        return view('compras.edit', compact('compra', 'proveedores', 'usuarios'));
    }

    public function update(UpdateCompraRequest $request, Compra $compra): RedirectResponse
    {
        $compra->update($request->validated());
        return redirect()->route('compras.index')->with('success', 'Compra actualizada exitosamente.');
    }

    public function destroy(Compra $compra): RedirectResponse
    {
        $compra->delete(); // Soft delete
        return redirect()->route('compras.index')->with('success', 'Compra eliminada lógicamente.');
    }
}