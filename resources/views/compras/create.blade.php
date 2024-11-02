@extends('adminlte::page')
@section('title', 'Registrar Compra')
@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Registrar Compra</h1>
        </div>
        <div class="col d-flex justify-content-end">
            <button type="submit" form="compraStoreForm" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
            <a href="{{ route('compras.index') }}" class="btn btn-secondary ml-2">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('compras.store') }}" method="POST" id="compraStoreForm">
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" id="codigo"
                                class="form-control @error('codigo') is-invalid @enderror" value="{{ $codigoGenerado }}"
                                readonly>
                            @error('codigo')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="proveedor">Proveedor</label>
                            <select name="proveedor_id" id="proveedor"
                                class="form-control @error('proveedor_id') is-invalid @enderror">
                                <option value="">Seleccione un proveedor</option>
                                @foreach ($otherModels['proveedores'] as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            @error('proveedor_id')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="plazo">Plazo (en días)</label>
                            <input type="number" name="plazo" id="plazo"
                                class="form-control @error('plazo') is-invalid @enderror"
                                placeholder="Ingrese el plazo de la compra" value="{{ old('plazo') }}" min="0"
                                max="30">
                            @error('plazo')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" name="trabajador_id" value="{{ auth()->user()->id }}">
                </div>
            </form>
        </div>
    </div>
@endsection
