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
            <form action="{{ route('productos.store') }}" method="POST" id="productosStoreForm">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre"
                        class="form-control @error('nombre') is-invalid @enderror"
                        placeholder="Ingrese el nombre del Producto" value="{{ old('nombre') }}">
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
                        placeholder="Ingrese la descripción del Producto" value="{{ old('descripcion') }}">
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
                        placeholder="Ingrese el precio del Producto" value="{{ old('precio') }}" min="1" step="0.01">
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
                        placeholder="Ingrese el stock del Producto" value="{{ old('stock') }}" min="1">
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
                        placeholder="Ingrese el codigo ubicacion del Producto" value="{{ old('codigoUbicacion') }}">
                    @error('codigoUbicacion')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="categoria">Categoría</label>
                    <select name="categoria_id" id="categoria"
                        class="form-control @error('categoria_id') is-invalid @enderror">
                        <option value="">Seleccione una categoría</option>
                        @foreach ($otherModels['categorias'] as $otherModel)
                            <option value="{{ $otherModel->id }}">{{ $otherModel->nombre }}</option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <div class="invalid-feedback">
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
