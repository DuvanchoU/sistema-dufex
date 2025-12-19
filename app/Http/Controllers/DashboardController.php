<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Produccion;
use App\Models\Roles;
use App\Models\Usuario;
use App\Models\Venta;
use App\Models\Pedido;
use App\Models\Compra;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalProductos' => Producto::count(),
            'totalCategorias' => Categoria::count(),
            'totalProducciones' => \App\Models\Produccion::count(),
            'totalRoles' => \App\Models\Roles::count(),
            'totalUsuarios' => \App\Models\Usuario::count(),
            'totalVentas'=> \App\Models\Venta::count(),
            'totalPedidos'=> \App\Models\Pedido::count(),
            'totalCompras'=> \App\Models\Compra::count(),           
        ]);
    }
}
