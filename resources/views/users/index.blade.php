@extends('adminlte::page')
@section('title', 'Gestión de Usuarios')
@section('content_header')
    <h1>Lista de Usuarios</h1>
@stop
@section('content')
    <x-alert-success></x-alert-success>
    <x-alert-danger></x-alert-danger>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <form action="{{ route('trabajadores.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="nombre" class="form-control"
                                placeholder="Ingrese el nombre del usuario" value="{{ request('nombre') }}">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-1">
                    <a href="{{ route('trabajadores.index') }}" class="btn btn-danger">
                        <i class="fas fa-sync"></i>
                    </a>
                </div>
                <div class="col d-flex justify-content-end">
                    <a href="{{ route('trabajadores.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Trabajador
                    </a>
                </div>
            </div>
        </div>
        <div class="p-0 card-body table-responsive">
            <x-data-table :data="$users" :titles="['DNI', 'Nombre', 'Correo', 'Fecha de Nacimiento', 'Rol', 'Acciones']" 
                :columns="[
                ['key' => 'dni'],
                ['key' => 'name'],
                ['key' => 'email'],
                ['key' => 'fecha_nacimiento'],
                ['key' => 'rol', 'relationship' => true, 'attribute' => 'nombre'],
            ]" :routes="[
                'edit' => 'trabajadores.edit',
                'disable' => 'trabajadores.disable',
                'enable' => 'trabajadores.enable',
            ]"></x-data-table>
        </div>
        <div class="card-footer d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
@stop
