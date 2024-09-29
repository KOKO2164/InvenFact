@extends('adminlte::page')
@section('title', 'Registrar Proveedor')
@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Registrar Proveedor</h1>
        </div>
        <div class="col d-flex justify-content-end">
            <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">
                <i class="fas fa-reply"></i> Volver
            </a>
        </div>
    </div>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('proveedores.store') }}" method="POST" id="proveedorStoreForm">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre del Proveedor">
                </div>
                @error('nombre')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                <div class="form-group">
                    <label for="ruc">RUC</label>
                    <input type="number" name="ruc" id="ruc" class="form-control" placeholder="Ingrese el ruc del Proveedor">
                </div>
                @error('ruc')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="Ingrese el email del Proveedor">
                </div>
                @error('email')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                <div class="form-group">
                    <label for="telefono">Telefono</label>
                    <input type="number" name="telefono" id="telefono" class="form-control" placeholder="Ingrese el telefono del Proveedor">
                </div>
                @error('telefono')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Ingrese el dirección del Proveedor">
                </div>
                @error('direccion')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" form="proveedorStoreForm">Registrar Proveedor</button>
        </div>
    </div>
@stop
