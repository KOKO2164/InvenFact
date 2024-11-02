@extends('adminlte::page')
@section('title', 'Editar Cliente')
@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Editar Cliente</h1>
        </div>
        <div class="col d-flex justify-content-end">
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                <i class="fas fa-reply"></i> Volver
            </a>
        </div>
    </div>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('clientes.update', $item->id) }}" method="POST" id="proveedorUpdateForm">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre"
                        class="form-control @error('nombre') is-invalid @enderror"
                        placeholder="Ingrese el nombre del Cliente" value="{{ old('nombre', $item->nombre) }}">
                    @error('nombre')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Ingrese el email del Cliente" value="{{ old('email', $item->email) }}">
                    @error('email')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" id="telefono"
                        class="form-control @error('telefono') is-invalid @enderror"
                        placeholder="Ingrese el telefono del Cliente" value="{{ old('telefono', $item->telefono) }}" minlength="9">
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
                        placeholder="Ingrese la dirección del Cliente" value="{{ old('direccion', $item->direccion) }}">
                    @error('direccion')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" form="proveedorUpdateForm" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </div>
@stop
