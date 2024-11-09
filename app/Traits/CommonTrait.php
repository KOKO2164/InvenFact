<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait CommonTrait
{
    private $tableCache;
    private const INDEX = '.index';

    public function getTableName()
    {
        if (!$this->tableCache) {
            $this->tableCache = (new $this->model())->getTable();
        }

        return $this->tableCache;
    }

    public function getOtherModelsData()
    {
        $otherModels = [];
        if ($this->otherModels()) {
            foreach ($this->otherModels() as $key => $model) {
                $otherModels[$key] = $model::where('estado', 1)->get();
            }
        }

        return $otherModels;
    }

    public function index(Request $request)
    {
        $query = $this->model::query();
        if ($request->has($this->searchField)) {
            $searchValue = $request->input($this->searchField);
            $query->where($this->searchField, 'like', "%$searchValue%");
        }

        $items = $query->paginate(10);

        return view($this->getTableName() . self::INDEX, compact('items'));
    }

    public function create()
    {
        $otherModels = $this->getOtherModelsData();

        return view($this->getTableName() . '.create', compact('otherModels'));
    }

    public function store(Request $request)
    {
        $request->validate($this->validationRules());

        try {
            $data = $request->all();

            if ($request->has('password')) {
                $data['password'] = bcrypt($request->input('password'));
            }

            $this->model::create($data);

            return redirect()->route($this->getTableName() . self::INDEX)->with('success', 'Registro creado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route($this->getTableName() . self::INDEX)->with('error', 'Ocurrió un error al crear el registro');
        }
    }

    public function edit($id)
    {
        $item = $this->model::find($id);
        $otherModels = $this->getOtherModelsData();

        return view($this->getTableName() . '.edit', compact(
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

            return redirect()->route((new $this->model())->getTable() . self::INDEX)->with('success', 'Registro modificado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route((new $this->model())->getTable() . self::INDEX)->with('error', 'Ocurrió un error al modificar el registro');
        }
    }

    public function disable($id)
    {
        try {
            $item = $this->model::find($id);
            $item->update(['estado' => 0]);

            return redirect()->route((new $this->model())->getTable() . self::INDEX)->with('success', 'Registro deshabilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route((new $this->model())->getTable() . self::INDEX)->with('error', 'Ocurrió un error al deshabilitar el registro');
        }
    }

    public function enable($id)
    {
        try {
            $item = $this->model::find($id);
            $item->update(['estado' => 1]);

            return redirect()->route((new $this->model())->getTable() . self::INDEX)->with('success', 'Registro habilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route((new $this->model())->getTable() . self::INDEX)->with('error', 'Ocurrió un error al habilitar el registro');
        }
    }
}
