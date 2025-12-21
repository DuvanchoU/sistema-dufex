<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\DetalleVenta;
use App\Models\Carrito;
use App\Models\ItemCarrito;
use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $carrito = $this->getCarritoActual();
        if ($carrito->items->isEmpty()) {
            return redirect()->route('tienda.index')->with('error', 'Tu carrito está vacío.');
        }

        return view('tienda.checkout', compact('carrito'));
    }

    public function procesar()
    {
        $carrito = $this->getCarritoActual();
        if ($carrito->items->isEmpty()) {
            return redirect()->route('carrito.index')->with('error', 'Carrito vacío.');
        }

        DB::beginTransaction();
        try {
            // Crear pedido
            $pedido = Pedido::create([
                'cliente_id' => $carrito->cliente_id, // o desde Auth::user()->cliente_id
                'usuario_id' => Auth::id(), // quién lo crea (puede ser el mismo cliente)
                'fecha_pedido' => now(),
                'total_pedido' => $carrito->total,
                'estado_pedido' => 'PENDIENTE',
                'direccion_entrega' => $carrito->cliente?->direccion ?? request('direccion_entrega'),
                'observaciones' => request('observaciones'),
            ]);

            // Asignar asesor comercial aleatorio
            $asesor = Usuario::whereHas('rol', function ($q) {
                $q->where('nombre_rol', 'ASESOR COMERCIAL');
            })->inRandomOrder()->first();

            $pedido->update(['asesor_id' => $asesor?->id_usuario]);

            // Crear detalles (asumiendo que tienes una tabla detalle_venta)
            foreach ($carrito->items as $item) {
                DetalleVenta::create([
                    'pedido_id' => $pedido->id_pedido,
                    'producto_id' => $item->producto_id,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->precio_unitario,
                    'subtotal' => $item->cantidad * $item->precio_unitario,
                ]);
            }

            // Vaciar carrito
            $carrito->items()->delete();
            $carrito->delete(); // o simplemente vaciar

            DB::commit();

            // Enviar notificación al gerente y asesor
            $this->enviarNotificacionNuevoPedido($pedido, $asesor);

            return redirect()->route('tienda.gracias', $pedido)->with('success', '¡Compra realizada con éxito!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors('Error al procesar tu compra. Por favor, intenta de nuevo.');
        }
    }

    private function enviarNotificacionNuevoPedido($pedido, $asesor)
    {
        // Notificación al gerente
        $gerente = Usuario::whereHas('rol', function ($q) {
            $q->where('nombre_rol', 'GERENTE');
        })->first();

        if ($gerente) {
            \Illuminate\Support\Facades\Notification::send($gerente, new \App\Notifications\NuevoPedidoNotification($pedido));
        }

        // Notificación al asesor
        if ($asesor) {
            \Illuminate\Support\Facades\Notification::send($asesor, new \App\Notifications\AsesorAsignadoNotification($pedido));
        }
    }

    private function getCarritoActual()
    {
        if (Auth::check()) {
            $cliente = Auth::user()->cliente; // Asumiendo que el usuario tiene un cliente asociado
            if (!$cliente) {
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