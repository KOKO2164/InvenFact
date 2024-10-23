@extends('adminlte::page')
@section('title', 'Gestión de Proveedores')
@section('content_header')
    <h1>Lista de Proveedores</h1>
@stop
@section('content')
    <x-alert-success></x-alert-success>
    <x-alert-danger></x-alert-danger>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-5">
                    <form action="{{ route('proveedores.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="nombre" class="form-control"
                                placeholder="Ingrese el nombre del proveedor" value="{{ request('nombre') }}">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-1">
                    <a href="{{ route('proveedores.index') }}" class="btn btn-danger">
                        <i class="fas fa-sync"></i>
                    </a>
                </div>
                <div class="col d-flex justify-content-end">
                    <a href="{{ route('proveedores.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Proveedor
                    </a>
                </div>
            </div>
        </div>
        <div class="p-0 card-body table-responsive">
            <x-data-table :data="$proveedores" :titles="['Nombre', 'RUC', 'Correo', 'Teléfono', 'Dirección', 'Estado', 'Acciones']"
                :columns="[
                    ['key' => 'nombre'],
                    ['key' => 'ruc'],
                    ['key' => 'email'],
                    ['key' => 'telefono'],
                    ['key' => 'direccion'],
                    ['key' => 'estado'],
                ]" :routes="[
                    'edit' => 'proveedores.edit',
                    'disable' => 'proveedores.disable',
                    'enable' => 'proveedores.enable',
                ]"></x-data-table>
        </div>
        <div class="card-footer d-flex justify-content-center">
            {{ $proveedores->links() }}
        </div>
    </div>
@stop
