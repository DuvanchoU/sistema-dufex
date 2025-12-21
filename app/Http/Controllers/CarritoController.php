<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Cliente;
use App\Models\ItemCarrito;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = $this->getCarritoActual();
        return view('tienda.carrito', compact('carrito'));
    }

    public function agregar($productoId, $cantidad = 1)
    {
        $producto = Producto::findOrFail($productoId);
        $carrito = $this->getCarritoActual();

        // Verificar si ya existe en el carrito
        $item = $carrito->items()->where('producto_id', $productoId)->first();

        if ($item) {
            $item->update(['cantidad' => $item->cantidad + $cantidad]);
        } else {
            $carrito->items()->create([
                'producto_id' => $productoId,
                'cantidad' => $cantidad,
                'precio_unitario' => $producto->precio_actual,
            ]);
        }

        return redirect()->route('carrito.index')->with('success', 'Producto agregado al carrito.');
    }

    public function actualizar($itemId, $cantidad)
    {
        $item = ItemCarrito::findOrFail($itemId);
        $item->update(['cantidad' => $cantidad]);
        return redirect()->route('carrito.index');
    }

    public function eliminar($itemId)
    {
        ItemCarrito::destroy($itemId);
        return redirect()->route('carrito.index');
    }

    private function getCarritoActual()
    {
        if (Auth::check()) {
            $cliente = Auth::user()->cliente; // Asumiendo que el usuario tiene un cliente asociado
            if (!$cliente) {
                // Si no tiene cliente, crear uno
                $cliente = Cliente::create([
                    'nombre' => Auth::user()->nombres,
                    'apellido' => Auth::user()->apellidos,
                    'email' => Auth::user()->correo_usuario,
                    'telefono' => Auth::user()->telefono,
                    'direccion' => Auth::user()->direccion ?? 'Sin dirección',
                    'estado' => 'ACTIVO',
                ]);
                Auth::user()->update(['cliente_id' => $cliente->id_cliente]); // Si tienes este campo en usuarios
            }
            return $cliente->carrito ?? $cliente->carrito()->create();
        }

        $sessionId = Session::getId();
        return Carrito::firstOrCreate(['session_id' => $sessionId]);
    }
}