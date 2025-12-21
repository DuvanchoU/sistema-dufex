<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProductoController,
    CategoriaController,
    DashboardController,
    ProduccionController,
    UsuariosController,
    RolesController,
    InventarioController,
    ProveedorController,
    BodegaController,
    VentaController,
    ClienteController,
    MetodoPagoController,
    PedidoController,
    CompraController,
    PermisoController,
    TiendaController,
    CarritoController,
    CheckoutController
};

Route::get('/', function () {
    return view('welcome');
});

// ---------------- AUTH ----------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ---------------- DASHBOARD ----------------
Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// ---------------- OPERACIÓN ----------------
Route::middleware(['auth','permiso:ver_productos'])->resource('productos', ProductoController::class)
    ->parameters(['productos' => 'producto']);

Route::middleware(['auth','permiso:ver_categorias'])->resource('categorias', CategoriaController::class)
    ->parameters(['categorias' => 'categoria']);

Route::middleware(['auth','permiso:ver_inventario'])->resource('inventario', InventarioController::class);

Route::middleware(['auth','permiso:ver_produccion'])->resource('produccion', ProduccionController::class);

Route::middleware(['auth','permiso:ver_bodegas'])->resource('bodegas', BodegaController::class);

Route::middleware(['auth','permiso:ver_proveedores'])->resource('proveedores', ProveedorController::class);

// ---------------- COMERCIAL ----------------
Route::middleware(['auth','permiso:ver_clientes'])->resource('clientes', ClienteController::class);

Route::middleware(['auth','permiso:ver_ventas'])->resource('ventas', VentaController::class)
    ->except(['edit','update']);

Route::middleware(['auth','permiso:ver_pedidos'])->resource('pedidos', PedidoController::class);

Route::middleware(['auth','permiso:ver_compras'])->resource('compras', CompraController::class);

Route::middleware(['auth','permiso:ver_metodos_pago'])->resource('metodos_pago', MetodoPagoController::class)
    ->parameters(['metodos_pago'=> 'metodopago']);

// ---------------- SEGURIDAD ----------------
Route::middleware(['auth','permiso:ver_usuarios'])->resource('usuarios', UsuariosController::class);

Route::middleware(['auth','permiso:ver_roles'])->resource('roles', RolesController::class)
    ->parameters(['roles' => 'rol']);

Route::middleware(['auth','permiso:ver_roles'])->get('/roles/{rol}/permisos', [RolesController::class, 'permisos'])
    ->name('roles.permisos');

Route::middleware(['auth','permiso:ver_roles'])->put('/roles/{rol}/permisos', [RolesController::class, 'actualizarPermisos'])
    ->name('roles.permisos.update');

Route::middleware(['auth','permiso:ver_permisos'])->resource('permisos', PermisoController::class)
    ->parameters(['permisos' => 'permiso']);


// ---------------- RUTAS PÚBLICAS (TIENDA) ----------------
Route::prefix('tienda')->name('tienda.')->group(function () {
    Route::get('/', [TiendaController::class, 'index'])->name('index');
    Route::get('/categoria/{categoria}', [TiendaController::class, 'categoria'])->name('categoria');
    Route::get('/producto/{producto}', [TiendaController::class, 'producto'])->name('producto');
    
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');
    Route::post('/carrito/agregar/{productoId}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::put('/carrito/actualizar/{itemId}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::delete('/carrito/eliminar/{itemId}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/procesar', [CheckoutController::class, 'procesar'])->name('checkout.procesar');
});

// ---------------- RUTA PARA GRACIAS DESPUÉS DE COMPRA ----------------
Route::get('/gracias/{pedido}', function ($pedido) {
    return view('tienda.gracias', compact('pedido'));
})->name('gracias');