@extends('adminlte::page')

@section('title', 'Reporte de Clientes')

@section('content_header')
    <h1>Reporte de Clientes</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Clientes</h3>
            <div class="card-tools">
                <a href="{{ route('reportes.exportar-clientes') }}" class="btn btn-success">
                    <i class="fas fa-download"></i> Exportar a Excel
                </a>
            </div>
        </div>
        <div class="p-0 card-body table-responsive">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Estado</th>
                        <th>Total Pedidos</th>
                        <th>Monto Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->nombre }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>{{ $cliente->telefono }}</td>
                        <td>{{ $cliente->direccion }}</td>
                        <td>
                            @if($cliente->estado)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>{{ $cliente->pedidos_count }}</td>
                        <td>S/ {{ number_format($cliente->pedidos_sum_total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $clientes->links() }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top 10 Clientes por Monto de Compra</h3>
                </div>
                <div class="card-body">
                    <canvas id="topClientesChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Distribución de Pedidos por Cliente</h3>
                </div>
                <div class="card-body">
                    <canvas id="distribucionPedidosChart" height="300"></canvas>
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
    // Obtener datos para los gráficos
    const clientes = @json($clientes);
    
    // Preparar datos para el gráfico de Top 10 clientes
    const clientesOrdenados = [...clientes.data].sort((a, b) => b.pedidos_sum_total - a.pedidos_sum_total).slice(0, 10);
    const nombresClientes = clientesOrdenados.map(cliente => cliente.nombre);
    const montosClientes = clientesOrdenados.map(cliente => cliente.pedidos_sum_total);
    
    // Gráfico de Top 10 clientes
    const ctxTopClientes = document.getElementById('topClientesChart').getContext('2d');
    new Chart(ctxTopClientes, {
        type: 'bar',
        data: {
            labels: nombresClientes,
            datasets: [{
                label: 'Monto total de compras',
                data: montosClientes,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: {
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
    
    // Datos para gráfico de distribución de pedidos
    const totalClientes = clientes.data.length;
    const clientesSinPedidos = clientes.data.filter(cliente => cliente.pedidos_count === 0).length;
    const clientesCon1a5 = clientes.data.filter(cliente => cliente.pedidos_count > 0 && cliente.pedidos_count <= 5).length;
    const clientesCon6a10 = clientes.data.filter(cliente => cliente.pedidos_count > 5 && cliente.pedidos_count <= 10).length;
    const clientesCon11a20 = clientes.data.filter(cliente => cliente.pedidos_count > 10 && cliente.pedidos_count <= 20).length;
    const clientesConMas20 = clientes.data.filter(cliente => cliente.pedidos_count > 20).length;
    
    // Gráfico de distribución de pedidos
    const ctxDistribucion = document.getElementById('distribucionPedidosChart').getContext('2d');
    new Chart(ctxDistribucion, {
        type: 'pie',
        data: {
            labels: ['Sin pedidos', '1-5 pedidos', '6-10 pedidos', '11-20 pedidos', 'Más de 20 pedidos'],
            datasets: [{
                data: [clientesSinPedidos, clientesCon1a5, clientesCon6a10, clientesCon11a20, clientesConMas20],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)'
                ],
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
                            const value = context.raw;
                            const percentage = Math.round((value / totalClientes) * 100);
                            return `${context.label}: ${value} clientes (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>
@stop