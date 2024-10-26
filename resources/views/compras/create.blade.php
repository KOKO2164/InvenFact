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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="trabajador">Trabajador</label>
                            <select name="trabajador" id="trabajador"
                                class="form-control @error('trabajador') is-invalid @enderror">
                                <option value="">Seleccione un trabajador</option>
                                @foreach ($trabajadores as $trabajador)
                                    <option value="{{ $trabajador->id }}">{{ $trabajador->name }}</option>
                                @endforeach
                            </select>
                            @error('trabajador')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="proveedor">Proveedor</label>
                            <select name="proveedor" id="proveedor"
                                class="form-control @error('proveedor') is-invalid @enderror"
                                onchange="seleccionarProveedor(this.value)">
                                <option value="">Seleccione un proveedor</option>
                                @foreach ($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                @endforeach
                            </select>
                            @error('proveedor')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="vendedor">Vendedor</label>
                            <select name="vendedor" id="vendedor"
                                class="form-control @error('vendedor') is-invalid @enderror" disabled>
                                <option value="">Seleccione un vendedor</option>
                            </select>
                            @error('vendedor')
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
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        async function seleccionarProveedor(proveedor_id) {
            $('#vendedor').prop('disabled', true);
            $('#vendedor').html('<option value="">Seleccione un vendedor</option>');
            if (!proveedor_id) return;

            try {
                const response = await fetch(`{{ route('obtener-trabajadores') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        proveedor_id
                    })
                });
                const data = await response.json();
                mostrarTrabajadoresPorProveedor(data);
            } catch (error) {
                console.error(error);
            }
        }

        function mostrarTrabajadoresPorProveedor(trabajadores) {
            if (trabajadores.length > 0) {
                var template = '';
                trabajadores.forEach(trabajador => {
                    template += `<option value="${trabajador.id}">${trabajador.nombre}</option>`;
                });
                $('#vendedor').prop('disabled', false);
                $('#vendedor').html(template);
            }
        }

        window.onload = function() {
            const proveedorSeleccionado = document.getElementById('proveedor').value;
            if (proveedorSeleccionado) {
                seleccionarProveedor(proveedorSeleccionado);
            }
        }
    </script>
@endsection
