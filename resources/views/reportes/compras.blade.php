@extends('adminlte::page')

@section('title', 'Reporte de Compras')

@section('content_header')
    <h1>Reporte de Compras</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filtrar Compras</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('reportes.compras') }}" method="GET" class="row">
                <div class="col-md-3 form-group">
                    <label>Fecha Desde</label>
                    <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                </div>
                <div class="col-md-3 form-group">
                    <label>Fecha Hasta</label>
                    <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                </div>
                <div class="col-md-3 form-group">
                    <label>Estado</label>
                    <select name="estado_id" class="form-control">
                        <option value="">Todos</option>
                        @foreach($estados as $estado)
                            <option value="{{ $estado->id }}" {{ request('estado_id') == $estado->id ? 'selected' : '' }}>
                                {{ $estado->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label>Proveedor</label>
                    <select name="proveedor_id" class="form-control select2">
                        <option value="">Todos</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}" {{ request('proveedor') == $proveedor->id ? 'selected' : '' }}>
                                {{ $proveedor->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="text-right col-md-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                    <a href="{{ route('reportes.compras') }}" class="btn btn-secondary">
                        <i class="fas fa-sync"></i> Reiniciar
                    </a>
                    <a href="{{ route('reportes.exportar-compras', request()->all()) }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Exportar a Excel
                    </a>
                    <a href="{{ route('reportes.pdf-compras', request()->all()) }}" class="btn btn-danger" target="_blank">
                        <i class="fas fa-file-pdf"></i> Generar PDF
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Compras</h3>
        </div>
        <div class="p-0 card-body table-responsive">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th>Items</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compras as $compra)
                    <tr>
                        <td>{{ $compra->id }}</td>
                        <td>{{ $compra->proveedor->nombre }}</td>
                        <td>{{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') }}</td>
                        <td>
                            <span>
                                {{ $compra->estado->nombre }}
                            </span>
                        </td>
                        <td>S/ {{ number_format($compra->total, 2) }}</td>
                        <td>{{ $compra->detalleCompras->count() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $compras->appends(request()->all())->links() }}
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pedidos por Estado</h3>
                </div>
                <div class="card-body">
                    <canvas id="pedidosEstadoChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ventas Mensuales</h3>
                </div>
                <div class="card-body">
                    <canvas id="ventasMensualesChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- <script>
document.addEventListener('DOMContentLoaded', function () {
    $('.select2').select2();

    // Datos para el gráfico de pedidos por estado
    const estadisticas = @json($estadisticas);

    // Gráfico de pedidos por estado
    const ctxEstados = document.getElementById('pedidosEstadoChart').getContext('2d');
    new Chart(ctxEstados, {
        type: 'pie',
        data: {
            labels: estadisticas.estados.map(e => e.nombre),
            datasets: [{
                data: estadisticas.estados.map(e => e.cantidad),
                backgroundColor: estadisticas.estados.map(e => e.color),
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
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${context.label}: ${value} pedidos (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Datos para el gráfico de ventas mensuales
    const ventasPorMes = estadisticas.ventas_mensuales || [];
    const meses = ventasPorMes.map(v => v.mes);
    const montos = ventasPorMes.map(v => v.total);

    // Gráfico de ventas mensuales
    const ctxVentas = document.getElementById('ventasMensualesChart').getContext('2d');
    new Chart(ctxVentas, {
        type: 'line',
        data: {
            labels: meses,
            datasets: [{
                label: 'Ventas Mensuales',
                data: montos,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                tension: 0.1
            }]
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
            }
        }
    });
});
</script> --}}
@stop
