@extends('adminlte::page')
@section('title', 'Editar Producto')
@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Editar Producto</h1>
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
            <form action="{{ route('productos.update', $producto) }}" method="POST" id="productosUpdateForm">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre"
                        class="form-control @error('nombre') is-invalid @enderror"
                        placeholder="Ingrese el nombre del Producto" value="{{ $producto->nombre }}">
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
                        placeholder="Ingrese la descripción del Producto" value="{{ $producto->descripcion }}">
                    @error('descripcion')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" name="precio" id="precio"
                        class="form-control @error('precio') is-invalid @enderror"
                        placeholder="Ingrese el precio del Producto" value="{{ $producto->precio }}">
                    @error('precio')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" name="stock" id="stock"
                        class="form-control @error('stock') is-invalid @enderror"
                        placeholder="Ingrese el stock del Producto" value="{{ $producto->stock }}">
                    @error('stock')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="codigoUbicacion">Código de ubicación</label>
                    <input type="text" name="codigoUbicacion" id="codigoUbicacion"
                        class="form-control @error('codigoUbicacion') is-invalid @enderror"
                        placeholder="Ingrese el código de ubicación del Producto"
                        value="{{ $producto->codigoUbicacion }}">
                    @error('codigoUbicacion')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="categoria">Categoría</label>
                    <select name="categoria" id="categoria"
                        class="form-control @error('categoria') is-invalid @enderror">
                        <option value="">Seleccione una categoría</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                {{ $categoria->id == $producto->categoria_id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                    @error('categoria')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" form="productosUpdateForm" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </div>
@stop
