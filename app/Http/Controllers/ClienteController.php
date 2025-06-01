<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver clientes')->only(['index']);
        $this->middleware('permission:crear clientes')->only(['create', 'store']);
        $this->middleware('permission:editar clientes')->only(['edit', 'update']);
        $this->middleware('permission:eliminar clientes')->only(['disable', 'enable']);
    }

    public function index(Request $request)
    {
        $query = Cliente::query();
        if ($request->has('nombre')) {
            $searchValue = $request->input('nombre');
            $query->where('nombre', 'like', "%$searchValue%");
        }

        $items = $query->paginate(10);

        return view('clientes.index', compact('items'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}0-9&\-\'\., ]+$/u',
            'email' => 'required|string|max:255',
            'direccion' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}\p{N}\-#°,\'\. ]+$/u',
            'telefono' => 'required|string|regex:/^[0-9\-\+ ]+$/|min:9|max:15',
        ]);

        try {
            Cliente::create($request->all());

            return redirect()->route('clientes.index')->with('success', 'Cliente creado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('clientes.index')->with('error', 'Ocurrió un error al crear el cliente');
        }
    }

    public function edit($id)
    {
        $item = Cliente::find($id);
        return view('clientes.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}0-9&\-\'\., ]+$/u',
            'email' => 'required|string|max:255',
            'direccion' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}\p{N}\-#°,\'\. ]+$/u',
            'telefono' => 'required|string|regex:/^[0-9\-\+ ]+$/|min:9|max:15',
        ]);

        try {
            $cliente = Cliente::find($id);
            $cliente->update($request->all());

            return redirect()->route('clientes.index')->with('success', 'Cliente modificado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('clientes.index')->with('error', 'Ocurrió un error al modificar el cliente');
        }
    }

    public function disable($id)
    {
        try {
            $cliente = Cliente::find($id);
            $cliente->update(['estado' => 0]);

            return redirect()->route('clientes.index')->with('success', 'Cliente deshabilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('clientes.index')->with('error', 'Ocurrió un error al deshabilitar el cliente');
        }
    }

    public function enable($id)
    {
        try {
            $cliente = Cliente::find($id);
            $cliente->update(['estado' => 1]);

            return redirect()->route('clientes.index')->with('success', 'Cliente habilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('clientes.index')->with('error', 'Ocurrió un error al habilitar el cliente');
        }
    }
}
