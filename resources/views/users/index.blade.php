@extends('adminlte::page')
@section('title', 'Gestión de Usuarios')
@section('content_header')
    <h1>Lista de Usuarios</h1>
@stop
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            <strong>{{ session('success') }}</strong>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            <strong>{{ session('error') }}</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Ingrese el nombre del usuario">
                </div>
                <div class="col d-flex justify-content-end">
                    <a href="{{ route('trabajadores.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Trabajador
                    </a>
                </div>
            </div>
        </div>
        <div class="p-0 card-body table-reponsive">
            <table class="table table-striped table-valign-middle">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->dni }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ \Carbon\Carbon::parse($user->fecha_nacimiento)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge badge-primary">{{ $user->rol->nombre }}</span>
                            </td>
                            <td>
                                <a href="{{ route('trabajadores.edit', $user) }}" class="btn btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                @if ($user->estado)
                                    @if ($user->id === auth()->user()->id)
                                        <button class="btn btn-danger" disabled>
                                            <i class="fas fa-user-slash"></i>
                                        </button>
                                    @else
                                        <form action="{{ route('trabajadores.disable', $user) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-danger" type="submit">
                                                <i class="fas fa-user-slash"></i>
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <form action="{{ route('trabajadores.enable', $user) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-success" type="submit">
                                            <i class="fas fa-user-check"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
@stop
