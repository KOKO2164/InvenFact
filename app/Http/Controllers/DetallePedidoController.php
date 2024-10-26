<?php

namespace App\Http\Controllers;

use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DetallePedidoController extends Controller
{
    public function index(Pedido $pedido)
    {

        try {
            $data = [];
            foreach ($pedido->detallePedidos as $detalle) {
                $data[] = [
                    'detalle' => $detalle,
                    'producto' => $detalle->producto
                ];
            }

            return response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function store(Request $request, Pedido $pedido)
    {
        Log::info('Producto a agregar: ' . $request->producto_id);
        $request->validate([
            'producto_id' => 'required|integer|exists:productos,id',
        ]);

        $producto = Producto::find($request->producto_id);

        if (!$producto) {
            return false;
        }

        DetallePedido::create([
            'pedido_id' => $pedido->id,
            'producto_id' => $request->producto_id,
            'cantidad' => 1
        ]);

        $pedido->update([
            'total' => $pedido->total + $producto->precio
        ]);

        return true;
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1'
        ]);

        $detallePedido = $pedido->detallePedidos()->where('producto_id', $request->producto_id)->firstOrFail();

        $cantidadAnterior = $detallePedido->cantidad;

        $costoAnterior = $cantidadAnterior * $detallePedido->producto->precio;
        $costoNuevo = $request->cantidad * $detallePedido->producto->precio;

        $detallePedido->update([
            'cantidad' => $request->cantidad
        ]);

        $pedido->update([
            'total' => $pedido->total - $costoAnterior + $costoNuevo
        ]);

        return response()->json($detallePedido, 200);
    }

    public function destroy(Pedido $pedido, Request $request)
    {
        $request->validate([
            'producto_id' => 'required|integer|exists:productos,id'
        ]);

        $detallePedido = $pedido->detallePedidos()->where('producto_id', $request->producto_id)->firstOrFail();

        $costo = $detallePedido->cantidad * $detallePedido->producto->precio;

        $pedido->update([
            'total' => $pedido->total - $costo
        ]);

        $detallePedido->delete();

        return response()->json($detallePedido, 200);
    }
}
