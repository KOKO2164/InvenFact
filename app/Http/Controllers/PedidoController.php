<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::orderBy('codigo', 'desc')->paginate(12);

        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ultimaCodigoPedido = Pedido::orderBy('codigo', 'desc')->first()->codigo ?? 'P000';
        $codigoGenerado = 'P' . str_pad((int)substr($ultimaCodigoPedido, 1) + 1, 3, '0', STR_PAD_LEFT); // C088
        $trabajadores = User::where([
            ['rol_id', 2],
            ['estado', 1]
        ])->get();
        $clientes = Cliente::where('estado', 1)->get();

        return view('pedidos.create', compact('codigoGenerado', 'clientes', 'trabajadores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|regex:/^P[0-9]{3}$/',
            'cliente' => 'required|integer|exists:clientes,id',
            'trabajador' => 'required|integer|exists:users,id',
            'plazo' => 'required|integer|min:0|max:30',
        ]);

        try {
            $pedido = Pedido::create([
                'codigo' => $request->codigo,
                'cliente_id' => $request->cliente,
                'trabajador_id' => $request->trabajador,
                'fecha' => now(),
                'plazo' => $request->plazo,
                'total' => 0,
                'cantidadProductos' => 0,
                'estado_id' => 1
            ]);

            return redirect()->route('pedidos.edit', $pedido)->with('success', '¡Pedido registrado correctamente!');
        } catch (\Exception $e) {
            return redirect()->route('pedidos.index')->with('error', 'Ocurrió un error al registrar el pedido. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        $trabajadores = User::where([
            ['rol_id', 2],
            ['estado', 1]
        ])->get();
        $clientes = Cliente::where('estado', 1)->get();

        return view('pedidos.edit', compact('pedido', 'clientes', 'trabajadores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'codigo' => 'required|string|regex:/^P[0-9]{3}$/',
            'cliente' => 'required|integer|exists:clientes,id',
            'trabajador' => 'required|integer|exists:users,id',
            'plazo' => 'required|integer|min:0|max:30',
        ]);

        try {
            $pedido->update([
                'codigo' => $request->codigo,
                'cliente_id' => $request->cliente,
                'trabajador_id' => $request->trabajador,
                'plazo' => $request->plazo,
            ]);

            return redirect()->route('pedidos.edit', $pedido)->with('success', '¡Pedido actualizado correctamente!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('pedidos.index')->with('error', 'Ocurrió un error al actualizar el pedido. Por favor, intenta nuevamente.');
        }
    }
}
