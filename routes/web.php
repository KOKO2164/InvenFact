<?php

use App\Http\Controllers\Auth\LoginController;
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

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::resource('/trabajadores', UserController::class)->except('show', 'destroy')->parameters(['trabajadores' => 'trabajador'])->middleware('auth');
Route::patch('/trabajadores/{trabajador}/deshabilitar', [UserController::class, 'disable'])->name('trabajadores.disable')->middleware('auth');
Route::patch('/trabajadores/{trabajador}/habilitar', [UserController::class, 'enable'])->name('trabajadores.enable')->middleware('auth');
