<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busqueda = $request->busqueda;
        if (empty($busqueda)) {
            $categorias = Categoria::latest('id')->paginate(10);
            $mensaje = 'Lista reestablecida';
        } else {
            $categorias = Categoria::where('id', 'LIKE', "%$busqueda%")
                ->orWhere('nombre', 'LIKE', "%$busqueda%")
                ->latest('id')
                ->paginate(2);

            if ($categorias->isEmpty()) {
                $mensaje = 'No se encontraron resultados para: ' . $busqueda;
            } else {
                $mensaje = 'Se encontraron ' . $categorias->total() . ' resultados para: ' . $busqueda;
            }
        }

        return view('categorias.index', [
            'categorias' => $categorias,
            'busqueda' => $busqueda,
            'mensaje' => $mensaje,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
        ]);

        try {
            Categoria::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'estado' => 1
            ]);

            return redirect()->route('categorias.index')->with('success', 'Categoria creada correctamente');
        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::error('Error: ' . $e->getMessage());
            return redirect()->route('categorias.index')->with('error', 'Ocurrió un error al crear la Categoria');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
        ]);

        try {
            $categoria->update([
                'nombre' => $request->nombre,
                "descripcion" => $request->descripcion,
                'estado' => 1
            ]);
            return redirect()->route('categorias.index')->with('success', 'Categoria creado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('categorias.index')->with('error', 'Ocurrió un error al crear el Categoria');
        }
    }

    public function disable(Categoria $categoria)
    {
        try {
            $categoria->update(['estado' => 0]);

            return redirect()->route('categorias.index')->with('success', 'Categoria deshabilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('categorias.index')->with('error', 'Ocurrió un error al deshabilitar el Categoria');
        }
    }

    public function enable(Categoria $categoria)
    {
        try {
            $categoria->update(['estado' => 1]);

            return redirect()->route('categorias.index')->with('success', 'Categoria habilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('categorias.index')->with('error', 'Ocurrió un error al habilitar el Categoria');
        }
    }
}
