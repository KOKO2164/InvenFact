<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DetalleCompraController extends Controller
{
    public function index(Compra $compra){

        try {
            $data = [];
            foreach ($compra->detalleCompras as $detalle) {
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

    public function store(Request $request, Compra $compra){
        Log::info('Producto a agregar: ' . $request->producto_id);
        $request->validate([
            'producto_id' => 'required|integer|exists:productos,id',
        ]);

        $producto = Producto::find($request->producto_id);

        if(!$producto){
            return false;
        }

        DetalleCompra::create([
            'compra_id' => $compra->id,
            'producto_id' => $request->producto_id,
            'cantidad' => 1
        ]);

        $compra->update([
            'total' => $compra->total + $producto->precio
        ]);

        return true;
    }

    public function update(Request $request, Compra $compra){
        $request->validate([
            'cantidad' => 'required|integer|min:1'
        ]);

        $detalleCompra = $compra->detalleCompras()->where('producto_id', $request->producto_id)->firstOrFail();

        $cantidadAnterior = $detalleCompra->cantidad;

        $costoAnterior = $cantidadAnterior * $detalleCompra->producto->precio;
        $costoNuevo = $request->cantidad * $detalleCompra->producto->precio;

        $detalleCompra->update([
            'cantidad' => $request->cantidad
        ]);

        $compra->update([
            'total' => $compra->total - $costoAnterior + $costoNuevo
        ]);

        return response()->json($detalleCompra, 200);
    }

    public function destroy(Compra $compra, Request $request)
    {
        $request->validate([
            'producto_id' => 'required|integer|exists:productos,id'
        ]);

        $detalleCompra = $compra->detalleCompras()->where('producto_id', $request->producto_id)->firstOrFail();

        $costo = $detalleCompra->cantidad * $detalleCompra->producto->precio;

        $compra->update([
            'total' => $compra->total - $costo
        ]);

        $detalleCompra->delete();

        return response()->json($detalleCompra, 200);
    }
}
