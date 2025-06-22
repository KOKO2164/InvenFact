<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetalleCompraController;
use App\Http\Controllers\DetallePedidoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Roles and permissions management routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'permission:ver usuarios'])->group(function () {
    Route::resource('roles', RoleController::class);
});

Route::resource('/trabajadores', UserController::class)->except('show', 'destroy')->names('users')->parameters(['trabajadores' => 'trabajador'])->middleware('auth');
Route::patch('/trabajadores/{trabajador}/deshabilitar', [UserController::class, 'disable'])->name('users.disable')->middleware('auth');
Route::patch('/trabajadores/{trabajador}/habilitar', [UserController::class, 'enable'])->name('users.enable')->middleware('auth');

Route::resource('/proveedores', ProveedorController::class)->except('show', 'destroy')->parameters(['proveedores' => 'proveedor'])->middleware('auth');
Route::patch('/proveedores/{proveedor}/deshabilitar', [ProveedorController::class, 'disable'])->name('proveedores.disable')->middleware('auth');
Route::patch('/proveedores/{proveedor}/habilitar', [ProveedorController::class, 'enable'])->name('proveedores.enable')->middleware('auth');

Route::resource('/categorias', CategoriaController::class)->except('show', 'destroy')->parameters(['categorias' => 'categoria'])->middleware('auth');
Route::patch('/categorias/{categoria}/deshabilitar', [CategoriaController::class, 'disable'])->name('categorias.disable')->middleware('auth');
Route::patch('/categorias/{categoria}/habilitar', [CategoriaController::class, 'enable'])->name('categorias.enable')->middleware('auth');

Route::resource('/productos', ProductoController::class)->except('show', 'destroy')->parameters(['productos' => 'producto'])->middleware('auth');
Route::patch('/productos/{producto}/deshabilitar', [ProductoController::class, 'disable'])->name('productos.disable')->middleware('auth');
Route::patch('/productos/{producto}/habilitar', [ProductoController::class, 'enable'])->name('productos.enable')->middleware('auth');

Route::resource('/compras', CompraController::class)->except('show', 'destroy')->parameters(['compras' => 'item'])->middleware('auth');
Route::get('/compras/{compra}/detalle', [DetalleCompraController::class, 'index'])->name('detalles-compras.index');
Route::post('/compras/{compra}/detalle', [DetalleCompraController::class, 'store'])->name('detalles-compras.store');
Route::patch('/compras/{compra}/detalle', [DetalleCompraController::class, 'update'])->name('detalles-compras.update');
Route::delete('/compras/{compra}/detalle', [DetalleCompraController::class, 'destroy'])->name('detalles-compras.destroy');
Route::patch('/compras/{compra}/update-estado', [CompraController::class, 'updateEstado'])->name('compras.update-estado')->middleware('auth');
Route::get('/compras/{item}/pdf', [CompraController::class, 'pdf'])->name('compras.pdf')->middleware('auth');

Route::resource('/clientes', ClienteController::class)->except('show', 'destroy')->parameters(['clientes' => 'cliente'])->middleware('auth');
Route::patch('/clientes/{cliente}/deshabilitar', [ClienteController::class, 'disable'])->name('clientes.disable')->middleware('auth');
Route::patch('/clientes/{cliente}/habilitar', [ClienteController::class, 'enable'])->name('clientes.enable')->middleware('auth');

Route::resource('/pedidos', PedidoController::class)->except('show', 'destroy')->parameters(['pedidos' => 'item'])->middleware('auth');
Route::get('/pedidos/{pedido}/detalle', [DetallePedidoController::class, 'index'])->name('detalles-pedidos.index');
Route::post('/pedidos/{pedido}/detalle', [DetallePedidoController::class, 'store'])->name('detalles-pedidos.store');
Route::patch('/pedidos/{pedido}/detalle', [DetallePedidoController::class, 'update'])->name('detalles-pedidos.update');
Route::delete('/pedidos/{pedido}/detalle', [DetallePedidoController::class, 'destroy'])->name('detalles-pedidos.destroy');
Route::patch('/pedidos/{pedido}/update-estado', [PedidoController::class, 'updateEstado'])->name('pedidos.update-estado')->middleware('auth');
Route::get('/pedidos/{item}/pdf', [PedidoController::class, 'pdf'])->name('pedidos.pdf')->middleware('auth');

Route::post('/obtener-productos', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'producto' => 'required|string'
    ]);

    return response()->json(\App\Models\Producto::where([
        ['nombre', 'LIKE', "%$request->producto%"],
        ['estado', 1]
    ])->get());
})->name('obtener-productos')->middleware('auth');

// Rutas de reportes
Route::middleware(['auth'])->prefix('reportes')->name('reportes.')->group(function () {
    Route::get('/', [ReporteController::class, 'index'])->name('index');
    Route::get('/productos', [ReporteController::class, 'productos'])->name('productos');
    Route::get('/clientes', [ReporteController::class, 'clientes'])->name('clientes');
    Route::get('/proveedores', [ReporteController::class, 'proveedores'])->name('proveedores');
    Route::get('/pedidos', [ReporteController::class, 'pedidos'])->name('pedidos');
    Route::get('/compras', [ReporteController::class, 'compras'])->name('compras');
    
    // Rutas de exportación
    Route::get('/exportar-productos', [ReporteController::class, 'exportProductos'])->name('exportar-productos');
    Route::get('/exportar-clientes', [ReporteController::class, 'exportClientes'])->name('exportar-clientes');
    Route::get('/exportar-proveedores', [ReporteController::class, 'exportProveedores'])->name('exportar-proveedores');
    Route::get('/exportar-pedidos', [ReporteController::class, 'exportPedidos'])->name('exportar-pedidos');
    Route::get('/exportar-compras', [ReporteController::class, 'exportCompras'])->name('exportar-compras');
});
