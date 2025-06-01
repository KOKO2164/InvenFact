<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver usuarios')->only(['index']);
        $this->middleware('permission:crear usuarios')->only(['create', 'store']);
        $this->middleware('permission:editar usuarios')->only(['edit', 'update']);
        $this->middleware('permission:eliminar usuarios')->only(['disable', 'enable']);
    }
    
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->has('name')) {
            $searchValue = $request->input('name');
            $query->where('name', 'like', "%$searchValue%");
        }

        $items = $query->paginate(10);

        return view('users.index', compact('items'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|numeric|digits:8|unique:users,dni',
            'name' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}0-9&\-\'\., ]+$/u',
            'fecha_nacimiento' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'rol' => 'required|in:' . implode(',', Role::pluck('name')->toArray()),
        ]);

        try {
            $data = $request->all();
            $data['password'] = bcrypt($request->input('password'));
            
            $user = User::create($data);
            
            // Asignar roles
            if ($request->has('rol')) {
                $user->syncRoles($request->rol);
            }

            return redirect()->route('users.index')->with('success', 'Usuario creado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('users.index')->with('error', 'Ocurrió un error al crear el usuario');
        }
    }

    public function edit($id)
    {
        $item = User::find($id);
        $roles = Role::all();
        return view('users.edit', compact('item', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'dni' => 'required|numeric|digits:8|unique:users,dni,' . $id,
            'name' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}0-9&\-\'\., ]+$/u',
            'fecha_nacimiento' => 'required|date',
            'email' => 'required|email|unique:users,email,' . $id,
            'rol' => 'required|in:' . implode(',', Role::pluck('name')->toArray()),
        ]);

        try {
            $user = User::find($id);
            $user->update($request->all());
            
            // Asignar roles
            if ($request->has('rol')) {
                $user->syncRoles($request->rol);
            }

            return redirect()->route('users.index')->with('success', 'Usuario modificado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('users.index')->with('error', 'Ocurrió un error al modificar el usuario');
        }
    }

    public function disable($id)
    {
        try {
            $user = User::find($id);
            $user->update(['estado' => 0]);

            return redirect()->route('users.index')->with('success', 'Usuario deshabilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('users.index')->with('error', 'Ocurrió un error al deshabilitar el usuario');
        }
    }

    public function enable($id)
    {
        try {
            $user = User::find($id);
            $user->update(['estado' => 1]);

            return redirect()->route('users.index')->with('success', 'Usuario habilitado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('users.index')->with('error', 'Ocurrió un error al habilitar el usuario');
        }
    }
}
