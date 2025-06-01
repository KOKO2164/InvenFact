@extends('adminlte::page')

@section('title', 'Reporte de Productos')

@section('content_header')
    <h1>Reporte de Productos</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filtrar resultados</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('reportes.productos') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="categoria_id">Categoría:</label>
                            <select name="categoria_id" id="categoria_id" class="form-control">
                                <option value="">Todas las categorías</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="stock_min">Stock mínimo:</label>
                            <input type="number" name="stock_min" id="stock_min" class="form-control" value="{{ request('stock_min') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="pt-4 mt-2 form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filtrar
                            </button>
                            <a href="{{ route('reportes.productos') }}" class="btn btn-secondary">
                                <i class="fas fa-sync-alt"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Productos</h3>
            <div class="card-tools">
                <form action="{{ route('reportes.exportar-productos') }}" method="GET">
                    <input type="hidden" name="categoria_id" value="{{ request('categoria_id') }}">
                    <input type="hidden" name="stock_min" value="{{ request('stock_min') }}">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-download"></i> Exportar a Excel
                    </button>
                </form>
            </div>
        </div>
        <div class="p-0 card-body table-responsive">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Ubicación</th>
                        <th>Estado</th>
                        <th>Valor Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->categoria->nombre }}</td>
                        <td>S/ {{ number_format($producto->precio, 2) }}</td>
                        <td>{{ $producto->stock }}</td>
                        <td>{{ $producto->codigoUbicacion }}</td>
                        <td>
                            @if($producto->estado)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>S/ {{ number_format($producto->precio * $producto->stock, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $productos->links() }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Valor de inventario por categoría</h3>
                </div>
                <div class="card-body">
                    <canvas id="inventarioValorChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cantidad de productos por categoría</h3>
                </div>
                <div class="card-body">
                    <canvas id="inventarioCantidadChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Agrupar productos por categoría para gráficos
    const productos = @json($productos);
    const categorias = @json($categorias);
    
    // Preparar datos para los gráficos
    const categoriasNombres = [];
    const valorPorCategoria = [];
    const cantidadPorCategoria = [];
    const colores = [
        'rgba(255, 99, 132, 0.8)',
        'rgba(54, 162, 235, 0.8)',
        'rgba(255, 206, 86, 0.8)',
        'rgba(75, 192, 192, 0.8)',
        'rgba(153, 102, 255, 0.8)',
        'rgba(255, 159, 64, 0.8)'
    ];
    
    // Procesar categorías
    categorias.forEach(function(categoria, index) {
        categoriasNombres.push(categoria.nombre);
        
        // Calcular valores para esta categoría
        let valor = 0;
        let cantidad = 0;
        
        productos.data.forEach(function(producto) {
            if (producto.categoria_id === categoria.id) {
                valor += producto.precio * producto.stock;
                cantidad++;
            }
        });
        
        valorPorCategoria.push(valor);
        cantidadPorCategoria.push(cantidad);
    });
    
    // Gráfico de valor de inventario por categoría
    const ctxValor = document.getElementById('inventarioValorChart').getContext('2d');
    new Chart(ctxValor, {
        type: 'pie',
        data: {
            labels: categoriasNombres,
            datasets: [{
                data: valorPorCategoria,
                backgroundColor: colores,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': S/ ' + context.raw.toLocaleString();
                        }
                    }
                }
            }
        }
    });
    
    // Gráfico de cantidad de productos por categoría
    const ctxCantidad = document.getElementById('inventarioCantidadChart').getContext('2d');
    new Chart(ctxCantidad, {
        type: 'bar',
        data: {
            labels: categoriasNombres,
            datasets: [{
                label: 'Cantidad de productos',
                data: cantidadPorCategoria,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
});
</script>
@stop