<?php

namespace App\Traits;

use App\Models\Compra;
use App\Models\Estado;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

trait ComplexTrait
{
    private $tableCache;
    private const INDEX = '.index';
    private const EDIT = '.edit';

    public function getTableName()
    {
        if (!$this->tableCache) {
            $this->tableCache = (new $this->model())->getTable();
        }

        return $this->tableCache;
    }

    public function index(Request $request)
    {
        $items = $this->model::where(function ($query) use ($request) {
            if ($request->has($this->searchField)) {
                $searchValue = $request->input($this->searchField);
                $query->where($this->searchField, 'like', "%$searchValue%");
            }
        })->paginate(10);

        $otherModels = [];
        if ($this->otherModels()) {
            foreach ($this->otherModels() as $key => $model) {
                $query = $model::query();
                if (!Schema::hasColumn($this->getTableName(), 'estado') && $this->model::first()) {
                    $query->orderBy('id', 'asc');
                }
                $otherModels[$key] = $query->get();
            }
        }

        foreach ($items as $item) {
            $item->avaibleStates = $this->getAvailableStates($item->estado_id);
        }

        return view($this->getTableName() . self::INDEX, compact('items', 'otherModels'));
    }

    public function create()
    {
        $otherModels = [];
        if ($this->otherModels()) {
            foreach ($this->otherModels() as $key => $model) {
                $query = $model::query();
                if (Schema::hasColumn($this->getTableName(), 'estado')) {
                    $query->where('estado', 1);
                }
                $otherModels[$key] = $query->get();
            }
        }
        $codigoGenerado = $this->otherVariables();

        return view($this->getTableName() . '.create', compact('otherModels', 'codigoGenerado'));
    }

    public function store(Request $request)
    {
        $request->validate($this->validationRules());

        try {
            $item = $this->model::create($request->all());

            return redirect()->route($this->getTableName() . self::EDIT, $item)->with('success', 'Registro creado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route($this->getTableName() . self::INDEX)->with('error', 'Ocurrió un error al crear el registro');
        }
    }

    public function edit($id)
    {
        $item = $this->model::find($id);
        $otherModels = [];
        if ($this->otherModels()) {
            foreach ($this->otherModels() as $key => $model) {
                $query = $model::query();
                if (Schema::hasColumn($this->getTableName(), 'estado')) {
                    $query->where('estado', 1);
                }
                $otherModels[$key] = $query->get();
            }
        }

        return view($this->getTableName() . self::EDIT, compact(
            'item',
            'otherModels'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->validationRules($id));
        try {
            $item = $this->model::find($id);
            $item->update($request->all());

            return redirect()->route($this->getTableName() . self::EDIT, $item)->with('success', 'Registro actualizado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route($this->getTableName() . self::INDEX)->with('error', 'Ocurrió un error al actualizar el registro');
        }
    }

    public function updateEstado(Request $request, $id)
    {
        try {
            $item = $this->model::findOrFail($id);
            $result = $this->validateAndProcessEstado($item, $request->estado_id);

            if (!$result['success']) {
                return redirect()
                    ->route($this->getTableName() . '.index')
                    ->with($result['type'], $result['message']);
            }

            $item->update(['estado_id' => $request->estado_id]);

            return redirect()
                ->route($this->getTableName() . '.index')
                ->with('success', 'Estado actualizado correctamente');
        } catch (\Exception $e) {
            Log::error('Error actualizando estado: ' . $e->getMessage());
            return redirect()
                ->route($this->getTableName() . '.index')
                ->with('error', 'Ocurrió un error al actualizar el estado');
        }
    }

    private function validateAndProcessEstado($item, $nuevoEstado): array
    {
        $availableStates = $this->getAvailableStates($item->estado_id);

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
            $resultInventario = $this->procesarInventario($item);
            if (!$resultInventario['success']) {
                return [
                    'success' => false,
                    'type' => 'error',
                    'message' => $resultInventario['message']
                ];
            }
        }

        return ['success' => true];
    }

    private function procesarInventario($item): array
    {
        if ($item instanceof Compra) {
            return $this->actualizarStockCompra($item);
        }
        return $this->actualizarStockPedido($item);
    }

    private function actualizarStockCompra($compra): array
    {
        foreach ($compra->detalleCompras as $detalle) {
            $producto = Producto::findOrFail($detalle->producto_id);
            $producto->increment('stock', $detalle->cantidad);
        }
        return ['success' => true];
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
