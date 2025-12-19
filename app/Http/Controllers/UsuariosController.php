<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Roles;
use App\Http\Requests\StoreUsuariosRequest;
use App\Http\Requests\UpdateUsuariosRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsuariosController extends Controller
{
    public function index(Request $request): View
    {
        $query = Usuario::with('rol')->orderBy('nombres');

        // Filtros
        if ($request->filled('nombre')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombres', 'LIKE', '%' . $request->nombre . '%')
                ->orWhere('apellidos', 'LIKE', '%' . $request->nombre . '%');
            });
        }

        if ($request->filled('documento')) {
            $query->where('documento', 'LIKE', '%' . $request->documento . '%');
        }

        if ($request->filled('correo_usuario')) {
            $query->where('correo_usuario', 'LIKE', '%' . $request->correo_usuario . '%');
        }

        if ($request->filled('rol_id')) {
            $query->where('id_rol', $request->rol_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('genero')) {
            $query->where('genero', $request->genero);
        }

        $usuarios = $query->paginate(15)->appends($request->query());

        $roles = Roles::all(['id_rol', 'nombre_rol']);

        return view('usuarios.index', compact('usuarios', 'roles'));
    }

    public function create(): View
    {
        $roles = Roles::all(['id_rol', 'nombre_rol']);
        return view('usuarios.create', compact('roles'));
    }

    public function store(StoreUsuariosRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['contrasena_usuario'] = bcrypt($data['contrasena_usuario']); // Encriptar contraseña
        Usuario::create($data);
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function show(Usuario $usuario): View
    {
        $usuario->load('rol', 'ventas', 'compras', 'pedidos');
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario): View
    {
        $roles = Roles::all(['id_rol', 'nombre_rol']);
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(UpdateUsuariosRequest $request, Usuario $usuario): RedirectResponse
    {
        $data = $request->validated();
        if ($request->filled('contrasena_usuario')) {
            $data['contrasena_usuario'] = bcrypt($data['contrasena_usuario']);
        } else {
            unset($data['contrasena_usuario']); // No actualizar contraseña si no se envía
        }
        $usuario->update($data);
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(Usuario $usuario): RedirectResponse
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario dado de baja exitosamente.');
    }
}
