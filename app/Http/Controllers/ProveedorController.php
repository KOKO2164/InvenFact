<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver proveedores')->only(['index']);
        $this->middleware('permission:crear proveedores')->only(['create', 'store']);
        $this->middleware('permission:editar proveedores')->only(['edit', 'update']);
        $this->middleware('permission:eliminar proveedores')->only(['disable', 'enable']);
    }

    public function index(Request $request)
    {
        $query = Proveedor::query();
        if ($request->has('nombre')) {
            $searchValue = $request->input('nombre');
            $query->where('nombre', 'like', "%$searchValue%");
        }

        $items = $query->paginate(10);

        return view('proveedores.index', compact('items'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}0-9&\-\'\., ]+$/u',
            'ruc' => 'required|numeric|digits:11|unique:proveedores,ruc',
            'email' => 'required|email|unique:proveedores,email',
            'telefono' => 'required|string|regex:/^[0-9\-\+ ]+$/|min:9|max:15',
            'direccion' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}\p{N}\-#°,\'\. ]+$/u'
        ]);

        try {
            Proveedor::create($request->all());

            return redirect()->route('proveedores.index')->with('success', 'Proveedor creado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('proveedores.index')->with('error', 'Ocurrió un error al crear el proveedor');
        }
    }

    public function edit($id)
    {
        $item = Proveedor::find($id);
        return view('proveedores.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}0-9&\-\'\., ]+$/u',
            'ruc' => 'required|numeric|digits:11|unique:proveedores,ruc,' . $id,
            'email' => 'required|email|unique:proveedores,email,' . $id,
            'telefono' => 'required|string|regex:/^[0-9\-\+ ]+$/|min:9|max:15',
            'direccion' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}\p{N}\-#°,\'\. ]+$/u'
        ]);

        try {
            $proveedor = Proveedor::find($id);
            $proveedor->update($request->all());

            return redirect()->route('proveedores.index')->with('success', 'Proveedor modificado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('proveedores.index')->with('error', 'Ocurrió un error al modificar el proveedor');
        }
    }

    public function disable($id)
    {
        try {
            $proveedor = Proveedor::find($id);
            $proveedor->update(['estado' => 0]);

            return redirect()->route('proveedores.index')->with('success', 'Proveedor deshabilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('proveedores.index')->with('error', 'Ocurrió un error al deshabilitar el proveedor');
        }
    }

    public function enable($id)
    {
        try {
            $proveedor = Proveedor::find($id);
            $proveedor->update(['estado' => 1]);

            return redirect()->route('proveedores.index')->with('success', 'Proveedor habilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('proveedores.index')->with('error', 'Ocurrió un error al habilitar el proveedor');
        }
    }
}
