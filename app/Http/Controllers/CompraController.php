<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Estado;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CompraController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver compras')->only(['index']);
        $this->middleware('permission:crear compras')->only(['create', 'store']);
        $this->middleware('permission:editar compras')->only(['edit', 'update']);
        $this->middleware('permission:eliminar compras')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = Compra::query();
        if ($request->has('codigo')) {
            $searchValue = $request->input('codigo');
            $query->where('codigo', 'like', "%$searchValue%");
        }
        
        $items = $query->paginate(10);
        
        // Cargar los modelos relacionados
        $proveedores = Proveedor::all();
        $estados = Estado::all();
        
        // Agregar estados disponibles a cada compra
        foreach ($items as $item) {
            $item->avaibleStates = $this->getAvailableStates($item->estado_id);
        }
        
        $otherModels = [
            'proveedores' => $proveedores,
            'estados' => $estados,
        ];

        return view('compras.index', compact('items', 'otherModels'));
    }

    public function create()
    {
        // Cargar los modelos relacionados para mostrar en el formulario
        $proveedores = Proveedor::where('estado', 1)->get();
        $estados = Estado::all();
        
        $otherModels = [
            'proveedores' => $proveedores,
            'estados' => $estados
        ];
        
        // Generar código para la nueva compra
        $ultimoCodigoCompra = Compra::orderBy('codigo', 'desc')->first()->codigo ?? 'C000';
        $codigoGenerado = 'C' . str_pad((int)substr($ultimoCodigoCompra, 1) + 1, 3, '0', STR_PAD_LEFT);

        return view('compras.create', compact('otherModels', 'codigoGenerado'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|regex:/^C[0-9]{3}$/|unique:compras,codigo',
            'proveedor_id' => 'required|integer|exists:proveedores,id',
            'trabajador_id' => 'required|integer|exists:users,id',
            'plazo' => 'required|integer|min:0|max:30',
        ]);

        try {
            $item = Compra::create($request->all());

            return redirect()->route('compras.edit', $item)->with('success', 'Compra creada correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('compras.index')->with('error', 'Ocurrió un error al crear la compra');
        }
    }

    public function edit($id)
    {
        $item = Compra::find($id);
        
        // Cargar los modelos relacionados para mostrar en el formulario
        $proveedores = Proveedor::where('estado', 1)->get();
        $estados = Estado::all();
        
        $otherModels = [
            'proveedores' => $proveedores,
            'estados' => $estados
        ];

        return view('compras.edit', compact('item', 'otherModels'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo' => 'required|string|regex:/^C[0-9]{3}$/|unique:compras,codigo,' . $id,
            'proveedor_id' => 'required|integer|exists:proveedores,id',
            'trabajador_id' => 'required|integer|exists:users,id',
            'plazo' => 'required|integer|min:0|max:30',
        ]);

        try {
            $compra = Compra::find($id);
            $compra->update($request->all());

            return redirect()->route('compras.edit', $compra)->with('success', 'Compra actualizada correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('compras.index')->with('error', 'Ocurrió un error al actualizar la compra');
        }
    }
    
    public function updateEstado(Request $request, $id)
    {
        try {
            $compra = Compra::findOrFail($id);
            $result = $this->validateAndProcessEstado($compra, $request->estado_id);

            if (!$result['success']) {
                return redirect()
                    ->route('compras.index')
                    ->with($result['type'], $result['message']);
            }

            $compra->update(['estado_id' => $request->estado_id]);

            return redirect()
                ->route('compras.index')
                ->with('success', 'Estado actualizado correctamente');
        } catch (\Exception $e) {
            Log::error('Error actualizando estado: ' . $e->getMessage());
            return redirect()
                ->route('compras.index')
                ->with('error', 'Ocurrió un error al actualizar el estado');
        }
    }
    
    private function validateAndProcessEstado($item, $nuevoEstado): array
    {
        $availableStates = $this->getAvailableStates($item->estado_id);
        $result = ['success' => true];

        if (!in_array($nuevoEstado, $availableStates)) {
            return [
                'success' => false,
                'type' => 'error',
                'message' => 'No se puede cambiar el estado a ese valor'
            ];
        }

        if ($nuevoEstado != 1 && $item->total == 0) {
            return [
                'success' => false,
                'type' => 'warning',
                'message' => 'No se puede cambiar el estado a ese valor, no hay productos en la compra'
            ];
        }

        if ($nuevoEstado == 7) {
            // Estado 7 es finalizado, actualizamos el inventario
            $resultInventario = $this->actualizarStockCompra($item);
            $result = !$resultInventario['success'] ? [
                'success' => false,
                'type' => 'error',
                'message' => $resultInventario['message']
            ] : $result;
        }

        return $result;
    }
    
    private function actualizarStockCompra($compra): array
    {
        foreach ($compra->detalleCompras as $detalle) {
            $producto = Producto::findOrFail($detalle->producto_id);
            $producto->increment('stock', $detalle->cantidad);
        }
        return ['success' => true];
    }

    public function getAvailableStates($currentStateId)
    {
        // Define las transiciones permitidas de estados
        $stateTransitions = [
            1 => [1, 2],
            2 => [2, 3, 4],
            3 => [3, 5],
            4 => [4],
            5 => [5, 6],
            6 => [6, 7],
            7 => [7],
        ];

        return isset($stateTransitions[$currentStateId]) ? $stateTransitions[$currentStateId] : [];
    }
}
