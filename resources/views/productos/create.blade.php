@extends('adminlte::page')
@section('title', 'Registrar Producto')
@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Registrar Producto</h1>
        </div>
        <div class="col d-flex justify-content-end">
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                <i class="fas fa-reply"></i> Volver
            </a>
        </div>
    </div>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('productos.store') }}" method="POST" id="productosStoreForm" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre del Producto">
                </div>
                @error('nombre')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Ingrese la descripción del Producto">
                </div>
                @error('descripcion')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" name="precio" id="precio" class="form-control" placeholder="Ingrese el precio del Producto">
                </div>
                @error('precio')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control" placeholder="Ingrese el stock del Producto">
                </div>
                @error('stock')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                <div class="form-group">
                    <label for="codigoUbicacion">Codigo de ubicacion</label>
                    <input type="text" name="codigoUbicacion" id="codigoUbicacion" class="form-control" placeholder="Ingrese el codigo ubicacion del Producto">
                </div>
                @error('codigoUbicacion')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                <div class="form-group">
                    <label for="imagen">Subir Imagen</label>
                    <input type="file" name="imagen" id="imagen" class="form-control" placeholder="Ingrese la imagen del Producto">
                </div>
                @error('imagen')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                <div class="form-group">
                    <label for="categoria_id">Categoría</label><br>
                    @foreach($categorias as $categoria)
                        <div class="form-check">
                            <input 
                                type="radio" 
                                name="categoria_id" 
                                id="categoria_{{ $categoria->id }}" 
                                value="{{ $categoria->id }}" 
                                class="form-check-input"
                            >
                            <label for="categoria_{{ $categoria->id }}" class="form-check-label">
                                {{ $categoria->nombre }} <!-- Asumiendo que 'nombre' es el campo que deseas mostrar -->
                            </label>
                        </div>
                    @endforeach
                    @error('categoria_id')
                        <div class="alert alert-danger">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" form="productosStoreForm">Registrar Producto</button>
        </div>
    </div>
@stop
