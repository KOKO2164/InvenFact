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
            <form action="{{ route('categorias.store') }}" method="POST" id="categoriaStoreForm" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre de la Categoria">
                </div>
                @error('nombre')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Ingrese la descripción de la Categoria">
                </div>
                @error('ruc')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                <div class="form-group">
                    <label for="imagen">Subir Imagen</label>
                    <input type="file" name="imagen" id="imagen" class="form-control" placeholder="Ingrese la imagen de la Categoria">
                </div>
                @error('email')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" form="categoriaStoreForm">Registrar Categoria</button>
        </div>
    </div>
@stop
