<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedor::paginate(10);

        return view('proveedores.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'ruc' => 'required|numeric|unique:proveedores|digits:11',
            'email' => 'required|email|unique:proveedores',
            'telefono' => 'required|numeric|min:9',
            'direccion' => 'required|string'
        ]);

        try {
            Proveedor::create([
                'nombre' => $request->nombre,
                "ruc" => $request->ruc,
                'email' => $request->email,
                "telefono" => $request->telefono,
                'direccion' => $request->direccion,
                'estado' => 1
            ]);

            return redirect()->route('proveedores.index')->with('success', 'Proveedor creado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('proveedores.index')->with('error', 'Ocurrió un error al crear el Proveedor');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proveedor $proveedor)
    {
        return view('proveedores.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'nombre' => 'required|string',
            'ruc' => 'required|numeric|digits:11|unique:proveedores,ruc,' . $proveedor->id,
            'email' => 'required|email|unique:proveedores,email,' . $proveedor->id,
            'telefono' => 'required|numeric|digits_between:9,15',
            'direccion' => 'required|string'
        ]);

        try {
            $proveedor->update([
                'nombre' => $request->nombre,
                "ruc" => $request->ruc,
                'email' => $request->email,
                "telefono" => $request->telefono,
                'direccion' => $request->direccion,
                'estado' => 1
            ]);

            return redirect()->route('proveedores.index')->with('success', 'Proveedor creado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('proveedores.index')->with('error', 'Ocurrió un error al editar el Proveedor');
        }
    }

    public function disable(Proveedor $proveedor)
    {
        try {
            $proveedor->update(['estado' => 0]);

            return redirect()->route('proveedores.index')->with('success', 'Proveedor deshabilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('proveedores.index')->with('error', 'Ocurrió un error al deshabilitar el proveedor');
        }
    }

    public function enable(Proveedor $proveedor)
    {
        try {
            $proveedor->update(['estado' => 1]);

            return redirect()->route('proveedores.index')->with('success', 'Proveedor habilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('proveedores.index')->with('error', 'Ocurrió un error al habilitar el proveedor');
        }
    }
}
