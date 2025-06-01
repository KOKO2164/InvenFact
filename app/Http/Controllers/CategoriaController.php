<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver categorias')->only(['index']);
        $this->middleware('permission:crear categorias')->only(['create', 'store']);
        $this->middleware('permission:editar categorias')->only(['edit', 'update']);
        $this->middleware('permission:eliminar categorias')->only(['disable', 'enable']);
    }

    public function index(Request $request)
    {
        $query = Categoria::query();
        if ($request->has('nombre')) {
            $searchValue = $request->input('nombre');
            $query->where('nombre', 'like', "%$searchValue%");
        }

        $items = $query->paginate(10);

        return view('categorias.index', compact('items'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|regex:/^[\p{L}0-9&\- ]+$/u|unique:categorias,nombre',
            'descripcion' => 'required|string'
        ]);

        try {
            Categoria::create($request->all());

            return redirect()->route('categorias.index')->with('success', 'Categoría creada correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('categorias.index')->with('error', 'Ocurrió un error al crear la categoría');
        }
    }

    public function edit($id)
    {
        $item = Categoria::find($id);
        return view('categorias.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|regex:/^[\p{L}0-9&\- ]+$/u|unique:categorias,nombre,'.$id,
            'descripcion' => 'required|string'
        ]);

        try {
            $categoria = Categoria::find($id);
            $categoria->update($request->all());

            return redirect()->route('categorias.index')->with('success', 'Categoría modificada correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('categorias.index')->with('error', 'Ocurrió un error al modificar la categoría');
        }
    }

    public function disable($id)
    {
        try {
            $categoria = Categoria::find($id);
            $categoria->update(['estado' => 0]);

            return redirect()->route('categorias.index')->with('success', 'Categoría deshabilitada correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('categorias.index')->with('error', 'Ocurrió un error al deshabilitar la categoría');
        }
    }

    public function enable($id)
    {
        try {
            $categoria = Categoria::find($id);
            $categoria->update(['estado' => 1]);

            return redirect()->route('categorias.index')->with('success', 'Categoría habilitada correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('categorias.index')->with('error', 'Ocurrió un error al habilitar la categoría');
        }
    }
}
