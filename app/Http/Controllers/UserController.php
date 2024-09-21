<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8'
            ]);

            User::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'rol_id' => 2,
                'estado' => 1
            ]);

            return redirect()->route('trabajadores.index')->with('success', 'Trabajador creado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('trabajadores.index')->with('error', 'Ocurrió un error al crear el trabajador');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $trabajador)
    {
        return view('users.edit', compact('trabajador'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $trabajador)
    {
        try {
            $request->validate([
                'nombre' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $trabajador->id
            ]);

            $trabajador->update([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'rol_id' => 2,
                'estado' => 1
            ]);

            return redirect()->route('trabajadores.index')->with('success', 'Trabajador modificado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('trabajadores.index')->with('error', 'Ocurrió un error al modificar el trabajador');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function disable(User $trabajador)
    {
        try {
            $trabajador->update(['estado' => 0]);

            return redirect()->route('trabajadores.index')->with('success', 'Trabajador deshabilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('trabajadores.index')->with('error', 'Ocurrió un error al deshabilitar el trabajador');
        }
    }

    public function enable(User $trabajador)
    {
        try {
            $trabajador->update(['estado' => 1]);

            return redirect()->route('trabajadores.index')->with('success', 'Trabajador habilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('trabajadores.index')->with('error', 'Ocurrió un error al habilitar el trabajador');
        }
    }
}
