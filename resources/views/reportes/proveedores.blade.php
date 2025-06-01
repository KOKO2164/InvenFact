@extends('adminlte::page')

@section('title', 'Reporte de Proveedores')

@section('content_header')
    <h1>Reporte de Proveedores</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Proveedores</h3>
            <div class="card-tools">
                <a href="{{ route('reportes.exportar-proveedores') }}" class="btn btn-success">
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
                        <th>Total Compras</th>
                        <th>Monto Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->id }}</td>
                        <td>{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->email }}</td>
                        <td>{{ $proveedor->telefono }}</td>
                        <td>{{ $proveedor->direccion }}</td>
                        <td>
                            @if($proveedor->estado)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>{{ $proveedor->compras_count }}</td>
                        <td>S/ {{ number_format($proveedor->compras_sum_total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $proveedores->links() }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top 10 Proveedores por Monto</h3>
                </div>
                <div class="card-body">
                    <canvas id="topProveedoresChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Compras por Proveedor (Últimos 12 meses)</h3>
                </div>
                <div class="card-body">
                    <canvas id="comprasMensualesChart" height="300"></canvas>
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
    const proveedores = @json($proveedores);
    const comprasMensuales = @json($comprasMensuales ?? []);
    
    // Preparar datos para el gráfico de Top 10 proveedores
    const proveedoresOrdenados = [...proveedores.data].sort((a, b) => b.compras_sum_total - a.compras_sum_total).slice(0, 10);
    const nombresProveedores = proveedoresOrdenados.map(proveedor => proveedor.nombre);
    const montosProveedores = proveedoresOrdenados.map(proveedor => proveedor.compras_sum_total);
    
    // Gráfico de Top 10 proveedores
    const ctxTopProveedores = document.getElementById('topProveedoresChart').getContext('2d');
    new Chart(ctxTopProveedores, {
        type: 'bar',
        data: {
            labels: nombresProveedores,
            datasets: [{
                label: 'Monto total de compras',
                data: montosProveedores,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
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
    
    // Gráfico de compras mensuales por proveedor
    if (comprasMensuales.length > 0) {
        const meses = comprasMensuales.map(item => item.mes);
        const topProveedores = proveedoresOrdenados.slice(0, 5); // Mostrar solo los 5 mejores
        
        const datasets = topProveedores.map((proveedor, index) => {
            // Asignar diferentes colores a cada proveedor
            const colores = [
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)'
            ];
            
            const datosProveedor = comprasMensuales
                .filter(item => item.proveedor_id === proveedor.id)
                .map(item => item.total);
                
            return {
                label: proveedor.nombre,
                data: datosProveedor,
                backgroundColor: colores[index % colores.length],
                borderColor: colores[index % colores.length].replace('0.5', '1'),
                borderWidth: 1
            };
        });
        
        const ctxComprasMensuales = document.getElementById('comprasMensualesChart').getContext('2d');
        new Chart(ctxComprasMensuales, {
            type: 'line',
            data: {
                labels: meses,
                datasets: datasets
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
    }
});
</script>
@stop