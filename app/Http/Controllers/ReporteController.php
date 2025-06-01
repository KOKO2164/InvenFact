<?php

namespace App\Http\Controllers;

use App\Exports\ClientesExport;
use App\Exports\ComprasExport;
use App\Exports\PedidosExport;
use App\Exports\ProductosExport;
use App\Exports\ProveedoresExport;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver reportes')->only(['index', 'productos', 'clientes', 'proveedores', 'pedidos', 'compras']);
        $this->middleware('permission:generar reportes')->only(['exportProductos', 'exportClientes', 'exportProveedores', 'exportPedidos', 'exportCompras']);
    }

    public function index()
    {
        // Obtener estadísticas generales para el dashboard de reportes
        $totalProductos = Producto::count();
        $totalClientes = Cliente::count();
        $totalProveedores = Proveedor::count();
        $totalPedidos = Pedido::count();
        $totalCompras = Compra::count();
        
        // Obtener top productos más vendidos
        $topProductos = DetallePedido::select('producto_id', DB::raw('SUM(cantidad) as total_vendido'))
            ->with('producto')
            ->groupBy('producto_id')
            ->orderByDesc('total_vendido')
            ->take(5)
            ->get();
            
        // Obtener top clientes por monto de compra
        $topClientes = Pedido::select('cliente_id', DB::raw('SUM(total) as total_compras'))
            ->with('cliente')
            ->groupBy('cliente_id')
            ->orderByDesc('total_compras')
            ->take(5)
            ->get();
            
        // Obtener compras por mes para gráfico
        $comprasPorMes = Compra::select(DB::raw('MONTH(fecha) as mes'), DB::raw('SUM(total) as total'))
            ->whereYear('fecha', date('Y'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->keyBy('mes')
            ->map(function ($item) {
                $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                return [
                    'mes' => $meses[$item->mes - 1],
                    'total' => $item->total
                ];
            });
            
        // Obtener pedidos por mes para gráfico
        $pedidosPorMes = Pedido::select(DB::raw('MONTH(fecha) as mes'), DB::raw('SUM(total) as total'))
            ->whereYear('fecha', date('Y'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->keyBy('mes')
            ->map(function ($item) {
                $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                return [
                    'mes' => $meses[$item->mes - 1],
                    'total' => $item->total
                ];
            });
            
        // Datos de inventario por categoría
        $inventarioPorCategoria = Categoria::with('productos')
            ->get()
            ->map(function ($categoria) {
                return [
                    'categoria' => $categoria->nombre,
                    'cantidad' => $categoria->productos->count(),
                    'valor' => $categoria->productos->sum(function ($producto) {
                        return $producto->precio * $producto->stock;
                    })
                ];
            });
        
        return view('reportes.index', compact(
            'totalProductos', 
            'totalClientes', 
            'totalProveedores', 
            'totalPedidos', 
            'totalCompras', 
            'topProductos', 
            'topClientes', 
            'comprasPorMes', 
            'pedidosPorMes', 
            'inventarioPorCategoria'
        ));
    }
    
    public function productos(Request $request)
    {
        $categorias = Categoria::all();
        $categoria_id = $request->input('categoria_id');
        
        $query = Producto::with('categoria');
        
        if ($categoria_id) {
            $query->where('categoria_id', $categoria_id);
        }
        
        if ($request->has('stock_min')) {
            $query->where('stock', '<=', $request->input('stock_min'));
        }
        
        $productos = $query->orderBy('nombre')->paginate(15);
        
        return view('reportes.productos', compact('productos', 'categorias'));
    }
    
    public function clientes()
    {
        $clientes = Cliente::withCount(['pedidos'])
            ->withSum('pedidos', 'total')
            ->orderBy('nombre')
            ->paginate(15);
            
        return view('reportes.clientes', compact('clientes'));
    }
    
    public function proveedores()
    {
        $proveedores = Proveedor::withCount(['compras'])
            ->withSum('compras', 'total')
            ->orderBy('nombre')
            ->paginate(15);
            
        return view('reportes.proveedores', compact('proveedores'));
    }
    
    public function pedidos(Request $request)
    {
        $query = Pedido::with(['cliente', 'trabajador']);
        
        if ($request->has('fecha_desde')) {
            $query->whereDate('fecha', '>=', $request->input('fecha_desde'));
        }
        
        if ($request->has('fecha_hasta')) {
            $query->whereDate('fecha', '<=', $request->input('fecha_hasta'));
        }
        
        if ($request->has('estado_id')) {
            $query->where('estado_id', $request->input('estado_id'));
        }
        
        $pedidos = $query->orderBy('fecha', 'desc')->paginate(15);
        $estados = DB::table('estados')->get();
        $clientes = Cliente::whereHas('pedidos')->get();
        
        // Preparar datos para gráficos
        /* $estadisticas = [
            'estados' => Pedido::select('estado_id', DB::raw('COUNT(*) as total'))
                ->groupBy('estado_id')
                ->with('estado')
                ->get()
                ->map(function($item) {
                    return [
                        'nombre' => $item->estado->nombre,
                        'cantidad' => $item->total,
                        'color' => $item->estado->color
                    ];
                }),
            'ventas_mensuales' => Pedido::select(DB::raw('MONTH(fecha) as mes'), DB::raw('SUM(total) as total'))
                ->whereYear('fecha', date('Y'))
                ->groupBy('mes')
                ->orderBy('mes')
                ->get()
                ->map(function ($item) {
                    $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                    return [
                        'mes' => $meses[$item->mes - 1],
                        'total' => $item->total
                    ];
                })
        ]; */
        
        return view('reportes.pedidos', compact('pedidos', 'estados', 'clientes'/* , 'estadisticas' */));
    }
    
    public function compras(Request $request)
    {
        $query = Compra::with(['proveedor', 'trabajador']);
        
        if ($request->has('fecha_desde')) {
            $query->where('fecha', '>=', $request->input('fecha_desde'));
        }
        
        if ($request->has('fecha_hasta')) {
            $query->where('fecha', '<=', $request->input('fecha_hasta'));
        }
        
        if ($request->has('estado_id')) {
            $query->where('estado_id', $request->input('estado_id'));
        }
        
        $compras = $query->orderBy('fecha', 'desc')->paginate(15);
        $estados = DB::table('estados')->get();
        $proveedores = Proveedor::whereHas('compras')->get();
        
        // Preparar datos para gráficos
        /* $estadisticas = [
            'Compras por Proveedor' => Compra::select('proveedor_id', DB::raw('COUNT(*) as total'))
                ->groupBy('proveedor_id')
                ->with('proveedor')
                ->get()
                ->map(function($item) {
                    return [
                        'label' => $item->proveedor->nombre,
                        'value' => $item->total
                    ];
                }),
            'Compras Mensuales' => Compra::select(DB::raw('MONTH(fecha) as mes'), DB::raw('SUM(total) as total'))
                ->whereYear('fecha', date('Y'))
                ->groupBy('mes')
                ->orderBy('mes')
                ->get()
                ->map(function($item) {
                    $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                    return [
                        'label' => $meses[$item->mes - 1],
                        'value' => $item->total
                    ];
                })
        ]; */
        
        return view('reportes.compras', compact('compras', 'estados', 'proveedores'/* , 'estadisticas' */));
    }
    
    public function exportProductos(Request $request)
    {
        $categoria_id = $request->input('categoria_id');
        $stock_min = $request->input('stock_min');
        
        return Excel::download(new ProductosExport($categoria_id, $stock_min), 'productos.xlsx');
    }
    
    public function exportClientes()
    {
        return Excel::download(new ClientesExport, 'clientes.xlsx');
    }
    
    public function exportProveedores()
    {
        return Excel::download(new ProveedoresExport, 'proveedores.xlsx');
    }
    
    public function exportPedidos(Request $request)
    {
        $fecha_desde = $request->input('fecha_desde');
        $fecha_hasta = $request->input('fecha_hasta');
        $estado_id = $request->input('estado_id');
        
        return Excel::download(new PedidosExport($fecha_desde, $fecha_hasta, $estado_id), 'pedidos.xlsx');
    }
    
    public function exportCompras(Request $request)
    {
        $fecha_desde = $request->input('fecha_desde');
        $fecha_hasta = $request->input('fecha_hasta');
        $estado_id = $request->input('estado_id');
        
        return Excel::download(new ComprasExport($fecha_desde, $fecha_hasta, $estado_id), 'compras.xlsx');
    }
}
