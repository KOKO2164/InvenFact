<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use App\Models\Trabajador;
use App\Models\Cliente;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $stockMayor = Producto::orderBy('stock', 'desc')->first();
        $stockMenor = Producto::orderBy('stock', 'asc')->first();
        $stockMenorLista = Producto::orderBy('stock', 'asc')->take(10);

        $ultimosCambiosProductos = Producto::latest()->take(3)->get();
        $ultimosCambiosCategorias = Categoria::latest()->take(3)->get();

        $productosPorCategoria = Categoria::withCount('productos')->get();

        $fechaActual = Carbon::now()->toDateString();
        $horaActual = Carbon::now()->toTimeString();
        $ubicacion = 'Lima, Peru 🇵🇪';
        
        $totalProductos = Producto::count();
        $totalCategorias = Categoria::count();
        $totalProveedores = Proveedor::count();
        $totalTrabajadores = User::where("rol_id", 2)->count();
        //$totalClientes = Cliente::count();

        return view('welcome', compact(
            'stockMayor', 'stockMenor', 'ultimosCambiosProductos', 'ultimosCambiosCategorias', 'productosPorCategoria',
            'fechaActual', 'horaActual', 'ubicacion', 'totalProductos', 'totalCategorias', 
            'totalProveedores', 'totalTrabajadores', "stockMenorLista", "user"
        ));
    }
}
