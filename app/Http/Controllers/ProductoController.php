<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver productos')->only(['index']);
        $this->middleware('permission:crear productos')->only(['create', 'store']);
        $this->middleware('permission:editar productos')->only(['edit', 'update']);
        $this->middleware('permission:eliminar productos')->only(['disable', 'enable']);
    }

    public function index(Request $request)
    {
        $query = Producto::query();
        if ($request->has('nombre')) {
            $searchValue = $request->input('nombre');
            $query->where('nombre', 'like', "%$searchValue%");
        }

        $items = $query->paginate(10);

        return view('productos.index', compact('items'));
    }

    public function create()
    {
        $categorias = Categoria::where('estado', 1)->get();
        return view('productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}0-9&\-\., ]+$/u|unique:productos,nombre',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'codigoUbicacion' => 'required|string|regex:/[A-Z]{2}[0-9]{2}/',
            'categoria_id' => 'required|numeric|exists:categorias,id'
        ]);

        try {
            Producto::create($request->all());

            return redirect()->route('productos.index')->with('success', 'Producto creado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('productos.index')->with('error', 'Ocurrió un error al crear el producto');
        }
    }

    public function edit($id)
    {
        $item = Producto::find($id);
        $categorias = Categoria::where('estado', 1)->get();
        return view('productos.edit', compact('item', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}0-9&\-\., ]+$/u|unique:productos,nombre,' . $id,
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'codigoUbicacion' => 'required|string|regex:/[A-Z]{2}[0-9]{2}/',
            'categoria_id' => 'required|numeric|exists:categorias,id'
        ]);

        try {
            $producto = Producto::find($id);
            $producto->update($request->all());

            return redirect()->route('productos.index')->with('success', 'Producto modificado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('productos.index')->with('error', 'Ocurrió un error al modificar el producto');
        }
    }

    public function disable($id)
    {
        try {
            $producto = Producto::find($id);
            $producto->update(['estado' => 0]);

            return redirect()->route('productos.index')->with('success', 'Producto deshabilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('productos.index')->with('error', 'Ocurrió un error al deshabilitar el producto');
        }
    }

    public function enable($id)
    {
        try {
            $producto = Producto::find($id);
            $producto->update(['estado' => 1]);

            return redirect()->route('productos.index')->with('success', 'Producto habilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('productos.index')->with('error', 'Ocurrió un error al habilitar el producto');
        }
    }
}
