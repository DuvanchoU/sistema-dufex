<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Categoria::withCount('productos');

        // Filtros
        if ($request->filled('nombre_categoria')) {
            $query->where('nombre_categoria', 'LIKE', '%' . $request->nombre_categoria . '%');
        }

        if ($request->filled('estado_categoria')) {
            $query->where('estado_categoria', $request->estado_categoria);
        }

        // Ordenar alfabéticamente
        $query->orderBy('nombre_categoria', 'ASC');

        $categorias = $query->paginate(15)->appends($request->query());

        return view('categorias.index', compact('categorias'));
    }

    public function create(): View
    {
        return view('categorias.create');
    }

    public function store(StoreCategoriaRequest $request): RedirectResponse
    {
        Categoria::create($request->validated());
        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function show(Categoria $categoria): View
    {
        $categoria->load('productos');
        return view('categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria): View
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(UpdateCategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        $categoria->update($request->validated());
        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        // Opción 1: Solo desactivar
        $categoria->estado_categoria = 'inactivo';
        $categoria->save();
        
        return redirect()->route('categorias.index')
                        ->with('success', 'Categoría desactivada.');
    }
}