@extends('adminlte::page')

@section('title', 'Dashboard de Reportes')

@section('content_header')
    <h1>Dashboard de Reportes</h1>
@stop

@section('content')
<div class="container-fluid">
    <!-- Tarjetas de estadísticas -->
    <div class="row">
        <div class="col-lg-2 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalProductos }}</h3>
                    <p>Productos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                <a href="{{ route('reportes.productos') }}" class="small-box-footer">
                    Ver detalle <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-2 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalClientes }}</h3>
                    <p>Clientes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('reportes.clientes') }}" class="small-box-footer">
                    Ver detalle <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-2 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalProveedores }}</h3>
                    <p>Proveedores</p>
                </div>
                <div class="icon">
                    <i class="fas fa-truck"></i>
                </div>
                <a href="{{ route('reportes.proveedores') }}" class="small-box-footer">
                    Ver detalle <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalPedidos }}</h3>
                    <p>Pedidos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <a href="{{ route('reportes.pedidos') }}" class="small-box-footer">
                    Ver detalle <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalCompras }}</h3>
                    <p>Compras</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dolly-flatbed"></i>
                </div>
                <a href="{{ route('reportes.compras') }}" class="small-box-footer">
                    Ver detalle <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Gráfico de ventas y compras por mes -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Resumen de Ventas y Compras por Mes</h3>
                </div>
                <div class="card-body">
                    <canvas id="ventasComprasMensuales" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Top Productos más vendidos -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top 5 Productos Más Vendidos</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @foreach($topProductos as $detalle)
                            <li class="item">
                                <div class="product-img">
                                    <i class="fas fa-box fa-2x text-info"></i>
                                </div>
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">
                                        {{ $detalle->producto->nombre }}
                                        <span class="badge badge-info float-right">{{ $detalle->total_vendido }} unidades</span>
                                    </a>
                                    <span class="product-description">
                                        {{ Str::limit($detalle->producto->descripcion, 50) }}
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Inventario por categoría -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Inventario por Categoría</h3>
                </div>
                <div class="card-body">
                    <canvas id="inventarioPorCategoria" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Top Clientes -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top 5 Clientes</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Total Compras</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topClientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->cliente->nombre }}</td>
                                    <td>S/ {{ number_format($cliente->total_compras, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    // Gráfico de ventas y compras mensuales
    const ctxVentasCompras = document.getElementById('ventasComprasMensuales').getContext('2d');
    
    // Datos para el gráfico
    const meses = [];
    const ventasData = [];
    const comprasData = [];
    
    // Procesar datos para el gráfico
    @foreach($pedidosPorMes as $item)
        meses.push('{{ $item["mes"] }}');
        ventasData.push({{ $item["total"] ?? 0 }});
    @endforeach
    
    @foreach($comprasPorMes as $item)
        if (!meses.includes('{{ $item["mes"] }}')) {
            meses.push('{{ $item["mes"] }}');
        }
        comprasData.push({{ $item["total"] ?? 0 }});
    @endforeach
    
    new Chart(ctxVentasCompras, {
        type: 'bar',
        data: {
            labels: meses,
            datasets: [
                {
                    label: 'Ventas',
                    data: ventasData,
                    backgroundColor: 'rgba(60, 141, 188, 0.5)',
                    borderColor: 'rgba(60, 141, 188, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Compras',
                    data: comprasData,
                    backgroundColor: 'rgba(210, 214, 222, 0.5)',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'S/ ' + value.toLocaleString();
                        }
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

    // Gráfico de inventario por categoría
    const ctxInventario = document.getElementById('inventarioPorCategoria').getContext('2d');
    
    // Datos para el gráfico de inventario
    const categorias = [];
    const cantidades = [];
    const colores = [
        'rgba(255, 99, 132, 0.8)',
        'rgba(54, 162, 235, 0.8)',
        'rgba(255, 206, 86, 0.8)',
        'rgba(75, 192, 192, 0.8)',
        'rgba(153, 102, 255, 0.8)',
        'rgba(255, 159, 64, 0.8)'
    ];
    
    @foreach($inventarioPorCategoria as $item)
        categorias.push('{{ $item["categoria"] }}');
        cantidades.push({{ $item["cantidad"] }});
    @endforeach
    
    new Chart(ctxInventario, {
        type: 'pie',
        data: {
            labels: categorias,
            datasets: [{
                data: cantidades,
                backgroundColor: colores,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        }
    });
});
</script>
@stop