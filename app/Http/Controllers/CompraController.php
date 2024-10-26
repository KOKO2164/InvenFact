<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\TrabajadorProveedor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = Compra::orderBy('codigo', 'desc')->paginate(12);

        return view('compras.index', compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ultimaCodigoCompra = Compra::orderBy('codigo', 'desc')->first()->codigo ?? 'C000'; // C087
        $codigoGenerado = 'C' . str_pad((int)substr($ultimaCodigoCompra, 1) + 1, 3, '0', STR_PAD_LEFT); // C088
        $trabajadores = User::where([
            ['rol_id', 2],
            ['estado', 1]
        ])->get();
        $proveedores = Proveedor::where('estado', 1)->get();

        return view('compras.create', compact('codigoGenerado', 'proveedores', 'trabajadores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|regex:/^C[0-9]{3}$/',
            'proveedor' => 'required|integer|exists:proveedores,id',
            'trabajador' => 'required|integer|exists:users,id',
            'vendedor' => 'required|integer|exists:trabajador_proveedores,id',
            'plazo' => 'required|integer|min:0|max:30',
        ]);

        try {
            $compra = Compra::create([
                'codigo' => $request->codigo,
                'proveedor_id' => $request->proveedor,
                'trabajador_id' => $request->trabajador,
                'trabajador_proveedor_id' => $request->vendedor,
                'fecha' => now(),
                'plazo' => $request->plazo,
                'total' => 0,
                'cantidadProductos' => 0,
                'estado_id' => 1
            ]);

            return redirect()->route('compras.edit', $compra)->with('success', '¡Compra registrada correctamente!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('compras.index')->with('error', '¡Error al registrar la compra!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Compra $compra)
    {
        $trabajadores = User::where([
            ['rol_id', 2],
            ['estado', 1]
        ])->get();
        $proveedores = Proveedor::where('estado', 1)->get();
        $vendedores = TrabajadorProveedor::where([
            ['proveedor_id', $compra->proveedor_id],
            ['estado', 1]
        ])->get();

        return view('compras.edit', compact(
            'compra',
            'proveedores',
            'trabajadores',
            'vendedores'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Compra $compra)
    {
        $request->validate([
            'codigo' => 'required|string|regex:/^C[0-9]{3}$/',
            'proveedor' => 'required|integer|exists:proveedores,id',
            'trabajador' => 'required|integer|exists:users,id',
            'vendedor' => 'required|integer|exists:trabajador_proveedores,id',
            'plazo' => 'required|integer|min:0|max:30',
        ]);

        try {
            $compra->update([
                'codigo' => $request->codigo,
                'proveedor_id' => $request->proveedor,
                'trabajador_id' => $request->trabajador,
                'trabajador_proveedor_id' => $request->vendedor,
                'plazo' => $request->plazo,
            ]);

            return redirect()->route('compras.edit', $compra)->with('success', '¡Compra actualizada correctamente!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('compras.index')->with('error', '¡Error al actualizar la compra!');
        }
    }
}
