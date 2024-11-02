@extends('adminlte::page')
@section('title', 'Registrar Pedido')
@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Registrar Pedido</h1>
        </div>
        <div class="col d-flex justify-content-end">
            <button type="submit" form="pedidoStoreForm" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary ml-2">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('pedidos.store') }}" method="POST" id="pedidoStoreForm">
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
                            <label for="cliente">Cliente</label>
                            <select name="cliente_id" id="cliente"
                                class="form-control @error('cliente_id') is-invalid @enderror">
                                <option value="">Seleccione un cliente</option>
                                @foreach ($otherModels['clientes'] as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="plazo">Plazo</label>
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
