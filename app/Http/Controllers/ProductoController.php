<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busqueda = $request->busqueda;
        if (empty($busqueda)) {
            $productos = Producto::latest('id')->paginate(12);
            $mensaje = 'Lista reestablecida';
        } else {
            $productos = Producto::where('id', 'LIKE', "%$busqueda%")
                ->orWhere('nombre', 'LIKE', "%$busqueda%")
                ->latest('id')
                ->paginate(10);

            if ($productos->isEmpty()) {
                $mensaje = 'No se encontraron resultados para: ' . $busqueda;
            } else {
                $mensaje = 'Se encontraron ' . $productos->total() . ' resultados para: ' . $busqueda;
            }
        }

        return view('productos.index', [
            'productos' => $productos,
            'busqueda' => $busqueda,
            'mensaje' => $mensaje,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|unique:productos',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'codigoUbicacion' => 'required|string',
            'imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'categoria' => 'required|numeric'
        ]);

        try {
            if (!$request->hasFile('imagen')) {
                return redirect()->back()->with('error', 'No file detected in the request.');
            }
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

            Producto::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'stock' => $request->stock,
                'codigoUbicacion' => $request->codigoUbicacion,
                'imagen' => 'images/categorias/' . $nameFile,
                'categoria_id' => $request->categoria,
                'estado' => 1
            ]);

            return redirect()->route('productos.index')->with('success', 'Producto creada correctamente');
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return redirect()->route('productos.index')->with('error', 'Ocurrió un error al crear la Producto');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'imagen' => 'required|string'
        ]);

        try {
            $producto->update([
                'nombre' => $request->nombre,
                "descripcion" => $request->descripcion,
                'imagen' => $request->imagen,
                'estado' => 1
            ]);
            return redirect()->route('productos.index')->with('success', 'Producto creado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('productos.index')->with('error', 'Ocurrió un error al crear el Producto');
        }
    }

    public function disable(Producto $producto)
    {
        try {
            $producto->update(['estado' => 0]);

            return redirect()->route('productos.index')->with('success', 'Producto deshabilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('productos.index')->with('error', 'Ocurrió un error al deshabilitar el Producto');
        }
    }

    public function enable(Producto $producto)
    {
        try {
            $producto->update(['estado' => 1]);

            return redirect()->route('productos.index')->with('success', 'Producto habilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('productos.index')->with('error', 'Ocurrió un error al habilitar el Producto');
        }
    }
}
