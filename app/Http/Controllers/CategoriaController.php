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
            $categorias = Categoria::where('id', 'LIKE', '%'.$busqueda.'%')
                ->orWhere('nombre', 'LIKE', '%'.$busqueda.'%')
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
        try {
            // Validate the input fields
            $request->validate([
                'nombre' => 'required|string',
                'descripcion' => 'required|string',
                'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Check if the file exists in the request
            if (!$request->hasFile('imagen')) {
                return redirect()->back()->with('error', 'No file detected in the request.');
            }

            // Check if the uploaded file is valid
            if (!$request->file('imagen')->isValid()) {
                return redirect()->back()->with('error', 'The uploaded file is invalid.');
            }

            $file = $request->file('imagen');
            $destinationPath = public_path('images/categorias/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $nameFile = time() . '-' . $file->getClientOriginalName();

            $file->move($destinationPath, $nameFile);

            Categoria::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'imagen' => 'images/categorias/' . $nameFile, 
                'estado' => 1
            ]);

            return redirect()->route('categorias.index')->with('success', 'Categoria creada correctamente');
        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::error('Error: ' . $e->getMessage());
            return redirect()->route('categorias.index')->with('error', 'Ocurrió un error al crear la Categoria: ' . $e->getMessage());
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
