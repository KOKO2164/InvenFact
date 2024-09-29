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
    public function index()
    {
        $categorias = Categoria::paginate(10);

        return view('categorias.index', compact('categorias'));
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
        try {
            $request->validate([
                'nombre' => 'required|string',
                'descripcion' => 'required|string',
                'imagen' => 'required|string'
            ]);

            Categoria::create([
                'nombre' => $request->nombre,
                "descripcion" => $request->descripcion,
                'imagen' => $request->imagen,
                'estado' => 1
            ]);
            return redirect()->route('categorias.index')->with('success', 'Categoria creado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('categorias.index')->with('error', 'Ocurrió un error al crear el Categoria');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $proveedor)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        try {
            $request->validate([
                'nombre' => 'required|string',
                'descripcion' => 'required|string',
                'imagen' => 'required|string'
            ]);

            $categoria->update([
                'nombre' => $request->nombre,
                "descripcion" => $request->descripcion,
                'imagen' => $request->imagen,
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
