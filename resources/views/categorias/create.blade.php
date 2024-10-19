@extends('adminlte::page')
@section('title', 'Registrar Categoria')
@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Registrar Categoria</h1>
        </div>
        <div class="col d-flex justify-content-end">
            <a href="{{ route('categorias.index') }}" class="btn btn-secondary">
                <i class="fas fa-reply"></i> Volver
            </a>
        </div>
    </div>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('categorias.store') }}" method="POST" id="categoriaStoreForm"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre"
                        class="form-control @error('nombre') is-invalid @enderror"
                        placeholder="Ingrese el nombre de la Categoria" value="{{ old('nombre') }}">
                    @error('nombre')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input type="text" name="descripcion" id="descripcion"
                        class="form-control @error('descripcion') is-invalid @enderror"
                        placeholder="Ingrese la descripción de la Categoria" value="{{ old('descripcion') }}">
                    @error('descripcion')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="imagen">Subir Imagen</label>
                    <input type="file" name="imagen" id="imagen"
                        class="form-control @error('imagen') is-invalid @enderror"
                        placeholder="Ingrese la imagen de la Categoria" value="{{ old('imagen') }}">
                    @error('imagen')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" form="categoriaStoreForm">Registrar Categoria</button>
        </div>
    </div>
@stop
