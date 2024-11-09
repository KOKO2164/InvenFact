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
    private const INDEX = '.index';
    private const EDIT = '.edit';
    
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
                if (!Schema::hasColumn((new $model())->getTable(), 'estado') && $this->model::first()) {
                    $query->orderBy('id', 'asc');
                }
                $otherModels[$key] = $query->get();
            }
        }

        foreach ($items as $item) {
            $item->avaibleStates = $this->getAvailableStates($item->estado_id);
        }

        return view((new $this->model())->getTable() . self::INDEX, compact('items', 'otherModels'));
    }

    public function create()
    {
        $otherModels = [];
        if ($this->otherModels()) {
            foreach ($this->otherModels() as $key => $model) {
                $query = $model::query();
                if (Schema::hasColumn((new $model())->getTable(), 'estado')) {
                    $query->where('estado', 1);
                }
                $otherModels[$key] = $query->get();
            }
        }
        $codigoGenerado = $this->otherVariables();

        return view((new $this->model())->getTable() . '.create', compact('otherModels', 'codigoGenerado'));
    }

    public function store(Request $request)
    {
        $request->validate($this->validationRules());

        try {
            $item = $this->model::create($request->all());

            return redirect()->route((new $this->model())->getTable() . self::EDIT, $item)->with('success', 'Registro creado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route((new $this->model())->getTable() . self::INDEX)->with('error', 'Ocurrió un error al crear el registro');
        }
    }

    public function edit($id)
    {
        $item = $this->model::find($id);
        $otherModels = [];
        if ($this->otherModels()) {
            foreach ($this->otherModels() as $key => $model) {
                $query = $model::query();
                if (Schema::hasColumn((new $model())->getTable(), 'estado')) {
                    $query->where('estado', 1);
                }
                $otherModels[$key] = $query->get();
            }
        }

        return view((new $this->model())->getTable() . self::EDIT, compact(
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

            return redirect()->route((new $this->model())->getTable() . self::EDIT, $item)->with('success', 'Registro actualizado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route((new $this->model())->getTable() . self::INDEX)->with('error', 'Ocurrió un error al actualizar el registro');
        }
    }

    public function updateEstado(Request $request, $id)
    {
        try {
            $item = $this->model::find($id);
            $availableStates = $this->getAvailableStates($item->estado_id);

            if (!in_array($request->estado_id, $availableStates)) {
                return redirect()->route((new $this->model())->getTable() . self::INDEX)
                    ->with('error', 'No se puede cambiar el estado a ese valor');
            }
            if ($request->estado_id != 1 && $item->total == 0) {
                return redirect()->route((new $this->model())->getTable() . self::INDEX)
                    ->with('warning', 'No se puede cambiar el estado a ese valor, no hay productos en la compra');
                
            }

            if ($request->estado_id == 7) {
                if ($item instanceof Compra) {
                    foreach ($item->detalleCompras as $detalle) {
                        $producto = Producto::find($detalle->producto_id);
                        $producto->update([
                            'stock' => $producto->stock + $detalle->cantidad
                        ]);
                    }
                } else {
                    foreach ($item->detallePedidos as $detalle) {
                        $producto = Producto::find($detalle->producto_id);

                        if ($detalle->cantidad > $producto->stock) {
                            return redirect()->route((new $this->model())->getTable() . self::INDEX)->with('error', 'No se puede cambiar el estado a finalizado, la cantidad solicitada supera el stock actual');
                        }
                        $producto->update([
                            'stock' => $producto->stock - $detalle->cantidad
                        ]);
                    }
                }
            }

            $item->update([
                'estado_id' => $request->estado_id
            ]);

            return redirect()->route((new $this->model())->getTable() . self::INDEX)->with('success', 'Estado actualizado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route((new $this->model())->getTable() . self::INDEX)->with('error', 'Ocurrió un error al actualizar el estado');
        }
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
