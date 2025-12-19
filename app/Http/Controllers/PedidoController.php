<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PedidoController extends Controller
{
    public function index(Request $request): View
    {
        $query = Pedido::with(['usuario', 'cliente']);

        // Filtros
        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->filled('estado_pedido')) {
            $query->where('estado_pedido', $request->estado_pedido);
        }

        if ($request->filled('direccion_entrega')) {
            $query->where('direccion_entrega', 'LIKE', '%' . $request->direccion_entrega . '%');
        }

        if ($request->filled('fecha_pedido')) {
            $query->whereDate('fecha_pedido', '>=', $request->fecha_pedido);
        }

        if ($request->filled('fecha_entrega')) {
            $query->whereDate('fecha_entrega_estimada', '>=', $request->fecha_entrega);
        }

        if ($request->filled('total_min')) {
            $query->where('total_pedido', '>=', $request->total_min);
        }

        if ($request->filled('total_max')) {
            $query->where('total_pedido', '<=', $request->total_max);
        }

        $pedidos = $query->paginate(15)->appends($request->query());

        $usuarios = Usuario::all(['id_usuario', 'nombres']);
        $clientes = Cliente::all(['id_cliente', 'nombre', 'apellido']);

        return view('pedidos.index', compact('pedidos', 'usuarios', 'clientes'));
    }

    public function create(): View
    {
        $usuarios = Usuario::all(['id_usuario', 'nombres']);
        $clientes = Cliente::all(['id_cliente', 'nombre', 'apellido']);
        return view('pedidos.create', compact('usuarios', 'clientes'));
    }

    public function store(StorePedidoRequest $request): RedirectResponse
    {
        Pedido::create($request->validated() + ['fecha_pedido' => $request->fecha_pedido ?? now()]);
        return redirect()->route('pedidos.index')->with('success', 'Pedido creado exitosamente.');
    }

    public function show(Pedido $pedido): View
    {
        $pedido->load(['usuario', 'cliente']);
        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido): View
    {
        $usuarios = Usuario::all(['id_usuario', 'nombres']);
        $clientes = Cliente::all(['id_cliente', 'nombre', 'apellido']);
        return view('pedidos.edit', compact('pedido', 'usuarios', 'clientes'));
    }

    public function update(UpdatePedidoRequest $request, Pedido $pedido): RedirectResponse
    {
        $pedido->update($request->validated());
        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado exitosamente.');
    }

    public function destroy(Pedido $pedido): RedirectResponse
    {
        $pedido->delete(); // Soft delete
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado lógicamente.');
    }
}