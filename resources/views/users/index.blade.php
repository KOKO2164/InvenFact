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
                    <input type="text" class="form-control w-50" placeholder="Ingrese el nombre del usuario">
                </div>
                <div class="col d-flex justify-content-end">
                    <a href="{{ route('trabajadores.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Trabajador
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body table-reponsive p-0">
            <table class="table table-striped table-valign-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->nombre }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge badge-primary">{{ $user->rol->nombre }}</span>
                            </td>
                            <td>
                                <a href="{{ route('trabajadores.edit', $user) }}" class="btn btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                @if ($user->estado)
                                    <form action="{{ route('trabajadores.disable', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-danger" type="submit">
                                            <i class="fas fa-user-slash"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('trabajadores.enable', $user) }}" method="POST" class="d-inline">
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
    </div>
@stop
