<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::resource('/trabajadores', UserController::class)->except('show', 'destroy')->parameters(['trabajadores' => 'trabajador'])->middleware('auth');
Route::patch('/trabajadores/{trabajador}/deshabilitar', [UserController::class, 'disable'])->name('trabajadores.disable')->middleware('auth');
Route::patch('/trabajadores/{trabajador}/habilitar', [UserController::class, 'enable'])->name('trabajadores.enable')->middleware('auth');

Route::resource('/proveedores', ProveedorController::class)->except('show', 'destroy')->parameters(['proveedores' => 'proveedor'])->middleware('auth');
Route::patch('/proveedores/{proveedor}/deshabilitar', [ProveedorController::class, 'disable'])->name('proveedores.disable')->middleware('auth');
Route::patch('/proveedores/{proveedor}/habilitar', [ProveedorController::class, 'enable'])->name('proveedores.enable')->middleware('auth');

Route::resource('/categorias', CategoriaController::class)->except('show', 'destroy')->parameters(['categorias' => 'categoria'])->middleware('auth');
Route::patch('/categorias/{categoria}/deshabilitar', [CategoriaController::class, 'disable'])->name('categorias.disable')->middleware('auth');
Route::patch('/categorias/{categoria}/habilitar', [CategoriaController::class, 'enable'])->name('categorias.enable')->middleware('auth');

Route::resource('/productos', ProductoController::class)->except('show', 'destroy')->parameters(['productos' => 'producto'])->middleware('auth');
Route::patch('/productos/{producto}/deshabilitar', [ProductoController::class, 'disable'])->name('productos.disable')->middleware('auth');
Route::patch('/productos/{producto}/habilitar', [ProductoController::class, 'enable'])->name('productos.enable')->middleware('auth');