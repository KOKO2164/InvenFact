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
                    <input type="text" name="nombre" id="nombre"
                        class="form-control @error('nombre') is-invalid @enderror"
                        placeholder="Ingrese el nombre del Proveedor" value="{{ old('nombre') }}">
                    @error('nombre')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="ruc">RUC</label>
                    <input type="string" name="ruc" id="ruc"
                        class="form-control @error('ruc') is-invalid @enderror" placeholder="Ingrese el ruc del Proveedor"
                        value="{{ old('ruc') }}" minlength="11" maxlength="11">
                    @error('ruc')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Ingrese el email del Proveedor" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="telefono">Telefono</label>
                    <input type="text" name="telefono" id="telefono"
                        class="form-control @error('telefono') is-invalid @enderror"
                        placeholder="Ingrese el telefono del Proveedor" value="{{ old('telefono') }}" minlength="9">
                    @error('telefono')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="direccion"
                        class="form-control @error('direccion') is-invalid @enderror"
                        placeholder="Ingrese el dirección del Proveedor" value="{{ old('direccion') }}">
                    @error('direccion')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" form="proveedorStoreForm">Registrar Proveedor</button>
        </div>
    </div>
@stop
