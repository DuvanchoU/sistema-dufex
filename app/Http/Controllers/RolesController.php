<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Http\Requests\StoreRolesRequest;
use App\Http\Requests\UpdateRolesRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Permiso;

class RolesController extends Controller
{
    public function index(): View
    {
        $roles = Roles::orderBy('nombre_rol')->paginate(15);
        return view('roles.index', compact('roles'));
    }

    public function create(): View
    {
        return view('roles.create');
    }

    public function store(StoreRolesRequest $request): RedirectResponse
    {
        Roles::create($request->validated());
        return redirect()->route('roles.index')
            ->with('success', 'Rol creado exitosamente.');
    }

    public function show(string $id_rol): View
    {
        $role = Roles::with('usuarios', 'permisos')->findOrFail($id_rol);
        return view('roles.show', compact('role'));
    }

    public function edit(string $id_rol): View
    {
        $role = Roles::findOrFail($id_rol);
        return view('roles.edit', compact('role'));
    }

    public function update(UpdateRolesRequest $request, string $id_rol): RedirectResponse
    {
        $role = Roles::findOrFail($id_rol);
        $role->update($request->validated());
        return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');
    }

    public function destroy(string $id_rol): RedirectResponse
    {
        $role = Roles::findOrFail($id_rol);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rol dado de baja exitosamente.');
    }

    public function permisos(Roles $rol): View
    {
        $permisos = Permiso::all();
        return view('roles.permisos', compact('rol', 'permisos'));
    }

    public function actualizarPermisos(Request $request, Roles $rol): RedirectResponse
    {
        $request->validate([
            'permisos' => 'array',
            'permisos.*' => 'exists:permisos,id_permiso',
        ]);

        // Sincroniza los permisos seleccionados
        $rol->permisos()->sync($request->permisos ?? []);

        return redirect()->route('roles.permisos', $rol)->with('success', 'Permisos actualizados exitosamente.');
    }
}