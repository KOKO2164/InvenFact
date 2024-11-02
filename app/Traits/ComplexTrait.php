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
        
        return view((new $this->model())->getTable() . '.index', compact('items', 'otherModels'));
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

            return redirect()->route((new $this->model())->getTable() . '.edit', $item)->with('success', 'Registro creado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route((new $this->model())->getTable() . '.index')->with('error', 'Ocurrió un error al crear el registro');
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

        return view((new $this->model())->getTable() . '.edit', compact(
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

            return redirect()->route((new $this->model())->getTable() . '.edit', $item)->with('success', 'Registro actualizado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route((new $this->model())->getTable() . '.index')->with('error', 'Ocurrió un error al actualizar el registro');
        }
    }

    public function updateEstado(Request $request, $id)
    {
        try {
            $item = $this->model::find($id);

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
                            return redirect()->route((new $this->model())->getTable() . '.index')->with('error', 'No se puede cambiar el estado a finalizado, la cantidad solicitada supera el stock actual');
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

            return redirect()->route((new $this->model())->getTable() . '.index')->with('success', 'Estado actualizado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route((new $this->model())->getTable() . '.index')->with('error', 'Ocurrió un error al actualizar el estado');
        }
    }
}
