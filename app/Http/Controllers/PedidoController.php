<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Estado;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver pedidos')->only(['index']);
        $this->middleware('permission:crear pedidos')->only(['create', 'store']);
        $this->middleware('permission:editar pedidos')->only(['edit', 'update']);
        $this->middleware('permission:eliminar pedidos')->only(['destroy']);
        $this->middleware('permission:procesar pedidos')->only(['updateEstado']);
    }

    public function index(Request $request)
    {
        $query = Pedido::query();
        if ($request->has('codigo')) {
            $searchValue = $request->input('codigo');
            $query->where('codigo', 'like', "%$searchValue%");
        }
        
        $items = $query->paginate(10);
        
        // Cargar los modelos relacionados
        $clientes = Cliente::all();
        $estados = Estado::all();
        
        // Agregar estados disponibles a cada pedido
        foreach ($items as $item) {
            $item->avaibleStates = $this->getAvailableStates($item->estado_id);
        }
        
        $otherModels = [
            'clientes' => $clientes,
            'estados' => $estados,
        ];

        return view('pedidos.index', compact('items', 'otherModels'));
    }

    public function create()
    {
        // Cargar los modelos relacionados para mostrar en el formulario
        $clientes = Cliente::where('estado', 1)->get();
        $estados = Estado::all();
        
        $otherModels = [
            'clientes' => $clientes,
            'estados' => $estados
        ];
        
        // Generar código para el nuevo pedido
        $ultimoCodigoPedido = Pedido::orderBy('codigo', 'desc')->first()->codigo ?? 'P000';
        $codigoGenerado = 'P' . str_pad((int)substr($ultimoCodigoPedido, 1) + 1, 3, '0', STR_PAD_LEFT);

        return view('pedidos.create', compact('otherModels', 'codigoGenerado'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|regex:/^P[0-9]{3}$/|unique:pedidos,codigo',
            'cliente_id' => 'required|integer|exists:clientes,id',
            'trabajador_id' => 'required|integer|exists:users,id',
            'plazo' => 'required|integer|min:0|max:30',
        ]);

        try {
            $item = Pedido::create($request->all());

            return redirect()->route('pedidos.edit', $item)->with('success', 'Pedido creado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('pedidos.index')->with('error', 'Ocurrió un error al crear el pedido');
        }
    }

    public function edit($id)
    {
        $item = Pedido::find($id);
        
        // Cargar los modelos relacionados para mostrar en el formulario
        $clientes = Cliente::where('estado', 1)->get();
        $estados = Estado::all();
        
        $otherModels = [
            'clientes' => $clientes,
            'estados' => $estados
        ];

        return view('pedidos.edit', compact('item', 'otherModels'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo' => 'required|string|regex:/^P[0-9]{3}$/|unique:pedidos,codigo,' . $id,
            'cliente_id' => 'required|integer|exists:clientes,id',
            'trabajador_id' => 'required|integer|exists:users,id',
            'plazo' => 'required|integer|min:0|max:30',
        ]);

        try {
            $pedido = Pedido::find($id);
            $pedido->update($request->all());

            return redirect()->route('pedidos.edit', $pedido)->with('success', 'Pedido actualizado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('pedidos.index')->with('error', 'Ocurrió un error al actualizar el pedido');
        }
    }
    
    public function updateEstado(Request $request, $id)
    {
        try {
            $pedido = Pedido::findOrFail($id);
            $result = $this->validateAndProcessEstado($pedido, $request->estado_id);

            if (!$result['success']) {
                return redirect()
                    ->route('pedidos.index')
                    ->with($result['type'], $result['message']);
            }

            $pedido->update(['estado_id' => $request->estado_id]);

            return redirect()
                ->route('pedidos.index')
                ->with('success', 'Estado actualizado correctamente');
        } catch (\Exception $e) {
            Log::error('Error actualizando estado: ' . $e->getMessage());
            return redirect()
                ->route('pedidos.index')
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
                'message' => 'No se puede cambiar el estado a ese valor, no hay productos en el pedido'
            ];
        }

        if ($nuevoEstado == 7) {
            // Estado 7 es finalizado, verificamos el inventario
            $resultInventario = $this->actualizarStockPedido($item);
            $result = !$resultInventario['success'] ? [
                'success' => false,
                'type' => 'error',
                'message' => $resultInventario['message']
            ] : $result;
        }

        return $result;
    }
    
    private function actualizarStockPedido($pedido): array
    {
        foreach ($pedido->detallePedidos as $detalle) {
            $producto = Producto::findOrFail($detalle->producto_id);

            if ($detalle->cantidad > $producto->stock) {
                return [
                    'success' => false,
                    'message' => 'No se puede cambiar el estado a finalizado, la cantidad solicitada supera el stock actual'
                ];
            }
            $producto->decrement('stock', $detalle->cantidad);
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
