<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait CommonTrait
{
    public function index(Request $request)
    {
        $items = $this->model::where(function ($query) use ($request) {
            if ($request->has($this->searchField)) {
                $searchValue = $request->input($this->searchField);
                $query->where($this->searchField, 'like', "%$searchValue%");
            }
        })->paginate(10);

        return view((new $this->model())->getTable() . '.index', compact('items'));
    }

    public function create()
    {
        $otherModels = [];
        if ($this->otherModels()) {
            foreach ($this->otherModels() as $key => $model) {
                $otherModels[$key] = $model::where('estado', 1)->get();
            }
        }

        return view((new $this->model())->getTable() . '.create', compact('otherModels'));
    }

    public function store(Request $request)
    {
        $request->validate($this->validationRules());

        try {
            $this->model::create($request->all());

            return redirect()->route((new $this->model())->getTable() . '.index')->with('success', 'Registro creado correctamente');
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
                $otherModels[$key] = $model::where('estado', 1)->get();
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

            return redirect()->route((new $this->model())->getTable() . '.index')->with('success', 'Registro modificado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route((new $this->model())->getTable() . '.index')->with('error', 'Ocurrió un error al modificar el registro');
        }
    }

    public function disable($id)
    {
        try {
            $item = $this->model::find($id);
            $item->update(['estado' => 0]);

            return redirect()->route((new $this->model())->getTable() . '.index')->with('success', 'Registro deshabilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route((new $this->model())->getTable() . '.index')->with('error', 'Ocurrió un error al deshabilitar el registro');
        }
    }

    public function enable($id)
    {
        try {
            $item = $this->model::find($id);
            $item->update(['estado' => 1]);

            return redirect()->route((new $this->model())->getTable() . '.index')->with('success', 'Registro habilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route((new $this->model())->getTable() . '.index')->with('error', 'Ocurrió un error al habilitar el registro');
        }
    }
}
