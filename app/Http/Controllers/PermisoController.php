<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Http\Requests\StorePermisoRequest;
use App\Http\Requests\UpdatePermisoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PermisoController extends Controller
{
    public function index(): View
    {
        $permisos = Permiso::paginate(15);
        return view('permisos.index', compact('permisos'));
    }

    public function create(): View
    {
        return view('permisos.create');
    }

    public function store(StorePermisoRequest $request): RedirectResponse
    {
        Permiso::create($request->validated());
        return redirect()->route('permisos.index')->with('success', 'Permiso creado exitosamente.');
    }

    public function show(Permiso $permiso): View
    {
        $permiso->load('roles');
        return view('permisos.show', compact('permiso'));
    }

    public function edit(Permiso $permiso): View
    {
        return view('permisos.edit', compact('permiso'));
    }

    public function update(UpdatePermisoRequest $request, Permiso $permiso): RedirectResponse
    {
        $permiso->update($request->validated());
        return redirect()->route('permisos.index')->with('success', 'Permiso actualizado exitosamente.');
    }

    public function destroy(Permiso $permiso): RedirectResponse
    {
        $permiso->delete(); // Soft delete
        return redirect()->route('permisos.index')->with('success', 'Permiso eliminado lógicamente.');
    }
}