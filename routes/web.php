<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\BodegaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\PermisoController;

use App\Http\Controllers\Reportes\ComprasPorClienteController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta del Dashboard , rutas protegidas
Route::middleware('auth')->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// Ruta de Productos
Route::resource('productos', ProductoController::class)
    ->parameters(['productos' => 'producto']);

// Ruta de Categorías
Route::resource('categorias', CategoriaController::class)
    ->parameters(['categorias' => 'categoria']);

// Ruta de Producción
Route::resource('produccion', ProduccionController::class)
    ->parameters(['produccion' => 'produccion']);

// Ruta de Usuarios
Route::resource('usuarios', UsuariosController::class)
    ->parameters(['usuarios' => 'usuario']);

// Ruta de Roles
Route::resource('roles', RolesController::class)
    ->parameters(['roles' => 'rol']);

// Gestión de permisos por rol
Route::get('/roles/{rol}/permisos', [RolesController::class, 'permisos'])->name('roles.permisos'); //  ver y editar permisos
Route::put('/roles/{rol}/permisos', [RolesController::class, 'actualizarPermisos'])->name('roles.permisos.update'); // guardar cambios

// Ruta de Inventario
Route::resource('inventario', InventarioController::class)
    ->parameters(['inventario' => 'inventario']);

// Ruta de Proveedores
Route::resource('proveedores', ProveedorController::class)
    ->parameters(['proveedores' => 'proveedor']);

// Ruta de Bodegas
Route::resource('bodegas', BodegaController::class)
    ->parameters(['bodegas' => 'bodega']);

// Ruta de Ventas
Route::resource('ventas', VentaController::class)
    ->except(['edit', 'update']);

// Ruta de Clientes
Route::resource('clientes', ClienteController::class);

// Ruta de Metodo De Pago
Route::resource('metodos_pago', MetodoPagoController::class)
    ->parameters(['metodos_pago'=> 'metodopago']);

// Ruta de Pedido
Route::resource('pedidos', PedidoController::class)
    ->parameters(['pedidos'=> 'pedido']);

// Ruta de Compras
Route::resource('compras', CompraController::class)
    ->parameters(['compras' => 'compra']);

// Ruta de Permisos
Route::resource('permisos', PermisoController::class)
    ->parameters(['permisos' => 'permiso']);

/////////////////////////////////////////////////////////

// Grupo de reportes
Route::prefix('reportes')->name('reportes.')->group(function () {
    Route::get('/compras-por-cliente', [ComprasPorClienteController::class, 'index'])
        ->name('compras-por-cliente');
      
    Route::get('/compras-por-cliente/excel', [ComprasPorClienteController::class, 'exportExcel'])
        ->name('compras-por-cliente.excel');

    Route::get('/compras-por-cliente/pdf', [ComprasPorClienteController::class, 'exportPdf'])
        ->name('compras-por-cliente.pdf');
}
);
});
