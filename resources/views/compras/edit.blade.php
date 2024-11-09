@extends('adminlte::page')
@section('title', 'Compra ' . $item->codigo)
@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Compra {{ $item->codigo }}</h1>
        </div>
        <div class="col d-flex justify-content-end">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalBuscarProductos">
                <i class="fas fa-plus"></i> Agregar Producto
            </button>
            <button type="submit" form="compraUpdateForm" class="ml-2 btn btn-primary">
                <i class="fas fa-save"></i> Actualizar
            </button>
            <a href="{{ route('compras.index') }}" class="ml-2 btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('compras.update', $item) }}" method="POST" id="compraUpdateForm">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" id="codigo"
                                class="form-control @error('codigo') is-invalid @enderror" value="{{ $item->codigo }}"
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
                                @foreach ($otherModels['proveedores'] as $model)
                                    <option value="{{ $model->id }}" @if ($item->proveedor_id == $model->id) selected @endif>
                                        {{ $model->nombre }}</option>
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
                                class="form-control @error('plazo') is-invalid @enderror" value="{{ $item->plazo }}">
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
    <div class="card">
        <div class="p-0 card-body table-responsive">
            <table class="table table-head-fixed text-nowrap">
                <thead>
                    <tr>
                        <th id="producto">Producto</th>
                        <th id="cantidad">Cantidad</th>
                        <th id="precioUnitario">Precio Unitario</th>
                        <th id="subtotal">Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tablaDetallesCompras">
                    @if ($item->detalleCompras->count() > 0)
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($item->detalleCompras as $detalleCompra)
                            @php
                                $total += $detalleCompra->cantidad * $detalleCompra->producto->precio;
                            @endphp
                            <tr>
                                <td>{{ $detalleCompra->producto->nombre }}</td>
                                <td><input type="number" class="form-control" value="{{ $detalleCompra->cantidad }}"
                                        onchange="actualizarDetalleCompra(event)"></td>
                                <td>{{ $detalleCompra->producto->precio }}</td>
                                <td>{{ $detalleCompra->cantidad * $detalleCompra->producto->precio }}</td>
                                <td class="d-none">{{ $detalleCompra->producto->id }}</td>
                                <td>
                                    <button type="button" class="btn btn-danger"
                                        onclick="eliminarDetalleCompra(event, {{ $detalleCompra->producto->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="3">Total</th>
                            <td>{{ $total }}</td>
                            <td></td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="5" class="text-center">No hay productos</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    {{-- Modal Productos --}}
    <div class="modal" id="modalBuscarProductos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buscar Productos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="p-0 modal-body">
                    <form onsubmit="buscarProductos(event)" class="p-3">
                        <div class="form-group">
                            <label for="producto">Producto</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="producto" placeholder="Ingresa el producto">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div id="spinnerProductos" class="spinner-border spinner-border-sm d-none" role="status">
                            </div>
                            <span id="textLoadingProductos" class="ml-2 d-none">Cargando...</span>
                        </div>
                    </form>
                    <table class="table table-head-fixed">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="tablaProductos"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        var lineas = 0;

        async function buscarProductos(e) {
            e.preventDefault();
            var producto = $('#producto').val();
            if (producto.length >= 1) {
                $('#spinnerProductos').removeClass('d-none');
                $('#textLoadingProductos').removeClass('d-none');
                try {
                    const source = await fetch('{{ route('obtener-productos') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            producto
                        })
                    });
                    const data = await source.json();
                    mostrarProductosModal(data);
                } catch (err) {
                    console.log(err);
                }
                $('#spinnerProductos').addClass('d-none');
                $('#textLoadingProductos').addClass('d-none');
            }
        }

        function mostrarProductosModal(productos) {
            if (productos.length > 0) {
                var template = '';
                productos.forEach(function(producto) {
                    template += `
					<tr>
						<td>${producto.nombre}</td>
						<td align="right">${producto.precio}</td>
						<td>
							<form onsubmit="agregarProducto(event)">
								<button class="btn btn-success btn-sm">
									<i class="fa fa-plus"></i>
								</button>
								<input type="hidden" name="producto_id" id="producto_id" value="${producto.id}">
							</form>
						</td>
					</tr>`;
                });
            } else {
                template = `
				<tr>
					<td colspan="3" align="center">No se encontraron registros</td>
				</tr>`;
            }
            $('#tablaProductos').html(template);
        }

        async function agregarProducto(e) {
            e.preventDefault();
            producto_id = parseInt(e.target.producto_id.value);

            try {
                const response = await fetch('{{ route('detalles-compras.index', $item->id) }}');
                var detalles = await response.json();

                const detalleExistente = detalles.find(detalle => detalle.detalle.producto_id === producto_id);

                if (detalleExistente) {
                    const cantidad = detalleExistente.detalle.cantidad + 1;
                    await fetch(`{{ route('detalles-compras.update', $item->id) }}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            cantidad,
                            producto_id
                        })
                    });
                } else {
                    const source = await fetch('{{ route('detalles-compras.store', $item->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            producto_id
                        })
                    });
                }

                consultarProductos();
            } catch (err) {
                console.log(err)
            }
        }

        async function consultarProductos() {
            try {
                const source = await fetch('{{ route('detalles-compras.index', $item->id) }}');
                const data = await source.json();
                lineas = data.length;
                mostrarProductos(data);
            } catch (err) {
                console.log(err)
            }
        }

        function mostrarProductos(productos) {
            var template = '';
            if (productos.length === 0) {
                template = `
                <tr>
                    <td colspan="5" class="text-center">No hay productos</td>
                </tr>`;
            } else {
                productos.forEach(function(producto) {
                    template += `
                    <tr>
                        <td>${producto.producto.nombre}</td>
                        <td><input type="number" class="form-control" value="${producto.detalle.cantidad}" onchange="actualizarDetalleCompra(event)"></td>
                        <td>${producto.producto.precio}</td>
                        <td>${producto.detalle.cantidad * producto.producto.precio}</td>
                        <td class="d-none">${producto.producto.id}</td>
                        <td><button type="button" class="btn btn-danger" onclick="eliminarDetalleCompra(event, ${producto.producto.id})"><i class="fas fa-trash"></i></button></td>
                    </tr>`;
                });
                template += `
                <tr>
                    <th colspan="3">Total</th>
                    <td>${productos.reduce((acc, producto) => acc + producto.detalle.cantidad * producto.producto.precio, 0)}</td>
                    <td></td>
                </tr>`;
            }
            $('#tablaDetallesCompras').html(template);
        }

        function actualizarDetalleCompra(e) {
            e.preventDefault();
            const cantidad = parseInt(e.target.value);
            const producto_id = parseInt(e.target.parentElement.parentElement.children[4].innerText);

            fetch(`{{ route('detalles-compras.update', $item->id) }}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cantidad,
                    producto_id
                })
            }).then(() => {
                consultarProductos();
            });
        }

        function eliminarDetalleCompra(e, producto_id) {
            e.preventDefault();

            fetch(`{{ route('detalles-compras.destroy', $item->id) }}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    producto_id
                })
            }).then(() => {
                consultarProductos();
            });
        }

        window.onload = function() {
            @if (session('success'))
                sessionStorage.setItem('success', '{{ session('success') }}');
            @endif
            @if (session('error'))
                sessionStorage.setItem('error', '{{ session('error') }}');
            @endif

            if (sessionStorage.getItem('success')) {
                Swal.fire({
                    icon: 'success',
                    title: 'Correcto',
                    text: sessionStorage.getItem('success'),
                    showConfirmButton: false,
                    timer: 3000
                });
                sessionStorage.removeItem('success');
            }
            if (sessionStorage.getItem('error')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: sessionStorage.getItem('error'),
                    showConfirmButton: false,
                    timer: 3000
                });
                sessionStorage.removeItem('error');
            }
        };
    </script>
@stop
