@extends('adminlte::page')

@section('title', 'Gestión de Proveedores')

@section('content_header')
    <h1>Lista de Proveedores</h1>
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
                    <input type="text" class="form-control w-50" placeholder="Buscar proveedor">
                </div>
                <div class="col d-flex justify-content-end">
                    <a href="{{ route('proveedores.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Proveedor
                    </a>
                </div>
            </div>
        </div>
        <div class="p-0 card-body table-responsive">
            <table class="table table-striped table-valign-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>RUC</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proveedores as $proveedor)
                        <tr>
                            <td>{{ $proveedor->nombre }}</td>
                            <td>{{ $proveedor->ruc }}</td>
                            <td>{{ $proveedor->email }}</td>
                            <td>{{ $proveedor->telefono }}</td>
                            <td>{{ $proveedor->direccion }}</td>
                            <td>
                                <span class="badge {{ $proveedor->estado ? 'badge-success' : 'badge-danger' }}">
                                    {{ $proveedor->estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                @if ($proveedor->estado)
                                    <form action="{{ route('proveedores.disable', $proveedor) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-danger" type="submit">
                                            <i class="fas fa-user-slash"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('proveedores.enable', $proveedor) }}" method="POST"
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
            {{ $proveedores->links() }}
        </div>
    </div>
@stop
