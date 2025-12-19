<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\MetodoPago;
use App\Models\Usuario;
use App\Http\Requests\StoreVentaRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Venta::with('usuario', 'cliente', 'metodoPago')->orderBy('fecha_venta', 'desc');

        // Filtros
        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }

        if ($request->filled('metodo_pago_id')) {
            $query->where('metodo_pago_id', $request->metodo_pago_id);
        }

        if ($request->filled('estado_venta')) {
            $query->where('estado_venta', $request->estado_venta);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_venta', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_venta', '<=', $request->fecha_hasta);
        }

        if ($request->filled('total_min')) {
            $query->where('total_venta', '>=', $request->total_min);
        }

        if ($request->filled('total_max')) {
            $query->where('total_venta', '<=', $request->total_max);
        }

        $ventas = $query->paginate(15)->appends($request->query());

        // Cargar listas para los selects
        $clientes = Cliente::where('estado', 'ACTIVO')->get(['id_cliente', 'nombre', 'apellido']);
        $usuarios = Usuario::where('estado', 'ACTIVO')->get(['id_usuario', 'nombres']);
        $metodosPago = MetodoPago::all(['id_metodo', 'nombre']);

        return view('ventas.index', compact('ventas', 'clientes', 'usuarios', 'metodosPago'));
    }

    public function create(): View
    {
        $clientes = Cliente::where('estado', 'ACTIVO')->get(['id_cliente', 'nombre', 'apellido']);
        $metodosPago = MetodoPago::all(['id_metodo', 'nombre']);
        $productos = Producto::with('categoria')->get(['id_producto', 'codigo_producto', 'referencia_producto', 'precio_actual']);
        return view('ventas.create', compact('clientes', 'metodosPago', 'productos'));
    }

    public function store(StoreVentaRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Calcular total
            $total = 0;
            foreach ($request->detalles as $detalle) {
                $producto = Producto::findOrFail($detalle['producto_id']);
                $subtotal = $producto->precio_actual * $detalle['cantidad'];
                $total += $subtotal;
            }

            // Crear venta
            $venta = Venta::create([
                'usuario_id'      => Auth::user()->id_usuario, // Asume que el usuario está autenticado
                'cliente_id'      => $request->cliente_id,
                'fecha_venta'     => now(),
                'total_venta'     => $total,
                'estado_venta'    => 'COMPLETADA',
                'metodo_pago_id'  => $request->metodo_pago_id,
            ]);

            // Crear detalles
            foreach ($request->detalles as $detalle) {
                $producto = Producto::findOrFail($detalle['producto_id']);
                DetalleVenta::create([
                    'venta_id'        => $venta->id_venta,
                    'producto_id'     => $producto->id_producto,
                    'cantidad'        => $detalle['cantidad'],
                    'precio_unitario' => $producto->precio_actual,
                    'subtotal'        => $producto->precio_actual * $detalle['cantidad'],
                ]);
            }

            DB::commit();
            return redirect()->route('ventas.index')->with('success', 'Venta registrada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear venta: ' . $e->getMessage());
            return back()->with('error', 'Error al procesar la venta. Intente nuevamente.');
        }
    }

    public function show(Venta $venta): View
    {
        $venta->load('detalles.producto', 'usuario', 'cliente', 'metodoPago');
        return view('ventas.show', compact('venta'));
    }

    public function destroy(Venta $venta): RedirectResponse
    {
        $venta->delete(); // Soft delete
        return redirect()->route('ventas.index')->with('success', 'Venta dada de baja exitosamente.');
    }

    // No se implementan edit() ni update() porque las ventas no se editan
}
