<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stockMayor = Producto::orderBy('stock', 'desc')->first();
        $stockMenor = Producto::orderBy('stock', 'asc')->first();
        $stockMenorLista = Producto::orderBy('stock', 'asc')->take(10);

        $ultimosCambiosProductos = Producto::latest()->take(3)->get();
        $ultimosCambiosCategorias = Categoria::latest()->take(3)->get();

        $productosPorCategoria = Categoria::withCount('productos')->get();

        $totalProductos = Producto::count();
        $totalCategorias = Categoria::count();
        $totalProveedores = Proveedor::count();
        $totalTrabajadores = User::where("rol_id", 2)->count();

        return view('welcome', compact(
            'stockMayor',
            'stockMenor',
            'stockMenorLista',
            'ultimosCambiosProductos',
            'ultimosCambiosCategorias',
            'productosPorCategoria',
            'totalProductos',
            'totalCategorias',
            'totalProveedores',
            'totalTrabajadores'
        ));
    }
}
