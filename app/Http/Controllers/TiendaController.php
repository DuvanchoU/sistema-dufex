<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;

class TiendaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::whereNull('deleted_at')->orderBy('nombre_categoria')->get();
        $productos = Producto::with('categoria', 'imagenes')
            ->whereNull('deleted_at')
            ->paginate(12);

        return view('tienda.index', compact('categorias', 'productos'));
    }

    public function categoria(Categoria $categoria)
    {
        $productos = $categoria->productos()
            ->whereNull('deleted_at')
            ->paginate(12);

        return view('tienda.categoria', compact('categoria', 'productos'));
    }

    public function producto(Producto $producto)
    {   
        $producto->load('imagenes');
        return view('tienda.producto', compact('producto'));
    }
}