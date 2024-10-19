@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Bienvenido, <span id="nombreUsuario">{{ auth()->user()->name }}</span></h3>
                    <h4><span id="correoUsuario">{{ auth()->user()->email }}</span></h4>
                    <h4>Tu Rol es <span id="rolUsuario"
                            style="color: rgba(0,150,0,1); font-weight: bold; background: white; padding-right: 4px; padding-left: 4px; border-radius: 10px;">
                            {{ auth()->user()->rol->nombre }}</span></h4>
                    <h4><span id="fechaActual">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</span>, <span
                            id="horaActual">{{ \Carbon\Carbon::now()->format('H:i:s') }}</span>
                    </h4>
                    <h4>Lima, Peru 🇵🇪</h4>

                </div>
                <div class="icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <span class="small-box-footer">
                    Información General <i class="fa fa-info-circle"></i>
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <x-adminlte-card title="Últimos Cambios en Productos" theme="info" icon="fas fa-history">
                <div class="list-group">
                    @foreach ($ultimosCambiosProductos as $producto)
                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $producto->nombre }}</h6>
                                <small>{{ $producto->created_at?->diffForHumans() ?? 'No date available' }}</small>
                            </div>
                        </a>
                    @endforeach
                </div>
            </x-adminlte-card>
        </div>
        <div class="col-md-4">
            <x-adminlte-card title="Últimos Cambios en Categorias" theme="warning" icon="fas fa-history">
                <div class="list-group">
                    @foreach ($ultimosCambiosCategorias as $categoria)
                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $categoria->nombre }}</h6>
                                <small>{{ $categoria->created_at?->diffForHumans() ?? 'No date available' }}</small>
                            </div>
                        </a>
                    @endforeach
                </div>
            </x-adminlte-card>
        </div>
        <div class="col-md-2">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $stockMayor->stock ?? 0 }}</h3>
                    <p>{{ $stockMayor->nombre ?? '' }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <span class="small-box-footer">
                    Stock mayor <i class="fa fa-boxes"></i>
                </span>
            </div>
        </div>
        <div class="col-md-2">
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3>{{ $stockMenor->stock ?? 0 }}</h3>
                    <p>{{ $stockMenor->nombre ?? '' }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                <span class="small-box-footer">
                    Stock Menor <i class="fa fa-box"></i>
                </span>
            </div>
        </div>

        <div class="col-md-2">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>{{ $totalProductos }}</h3>
                    <p>Productos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cube"></i>
                </div>
                <span class="small-box-footer">
                    Total Productos <i class="fa fa-box"></i>
                </span>
            </div>
        </div>

        <div class="col-md-2">
            <div class="small-box bg-cyan">
                <div class="inner">
                    <h3>{{ $totalCategorias }}</h3>
                    <p>Categorias</p>
                </div>
                <div class="icon">
                    <i class="fas fa-th-list"></i>
                </div>
                <span class="small-box-footer">
                    Total Categorias <i class="fa fa-th-list"></i>
                </span>
            </div>
        </div>

        <div class="col-md-2">
            <div class="small-box bg-pink">
                <div class="inner">
                    <h3>{{ $totalTrabajadores }}</h3>
                    <p>Trabajadores</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <span class="small-box-footer">
                    Total Trabajadores <i class="fa fa-users"></i>
                </span>
            </div>
        </div>

        <div class="col-md-2">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $totalProveedores }}</h3>
                    <p>Proveedores</p>
                </div>
                <div class="icon">
                    <i class="fas fa-truck-loading"></i>
                </div>
                <span class="small-box-footer">
                    Total Proveedores <i class="fa fa-truck-loading"></i>
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <x-adminlte-card title="Productos por Categoría" theme="primary" icon="fas fa-chart-pie">
                <canvas id="productosPorCategoriaChart" width="320" height="300"></canvas>
            </x-adminlte-card>
        </div>
        <div class="col-md-4">
            <x-adminlte-card title="Productos por Stock" theme="danger" icon="fas fa-chart-bar">
                <canvas id="productosPorStock" width="320" height="300"></canvas>
            </x-adminlte-card>
        </div>
        <div class="col-md-4">
            <x-adminlte-card title="Ventas por mes" theme="pink" icon="fas fa-chart-line">
                <canvas id="ventasPorFecha" width="320" height="300"></canvas>
            </x-adminlte-card>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('productosPorCategoriaChart').getContext('2d');
        const productosPorCategoriaChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($productosPorCategoria->pluck('nombre')) !!},
                datasets: [{
                    label: '->Cantidad',
                    data: {!! json_encode($productosPorCategoria->pluck('productos_count')) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)', // Rojo vibrante
                        'rgba(54, 162, 235, 1)', // Azul suave
                        'rgba(255, 206, 86, 1)', // Amarillo brillante
                        'rgba(75, 192, 192, 1)', // Verde agua
                        'rgba(153, 102, 255, 1)', // Púrpura
                        'rgba(255, 159, 64, 1)', // Naranja cálido
                        'rgba(201, 203, 207, 1)', // Gris suave
                        'rgba(46, 204, 113, 1)', // Verde fuerte
                        'rgba(231, 76, 60, 1)' // Rojo intenso
                    ],
                }]
            },
            options: {
                maintainAspectRatio: false
            }
        });
    </script>
    <script>
        const ctxStock = document.getElementById('productosPorStock').getContext('2d');
        const stockChart = new Chart(ctxStock, {
            type: 'bar',
            data: {
                labels: {!! json_encode($stockMenorLista->pluck('nombre')) !!},
                datasets: [{
                    label: 'Cantidad',
                    data: {!! json_encode($stockMenorLista->pluck('stock')) !!},
                    backgroundColor: [
                        'rgba(255, 10, 10, 1)',
                        'rgba(255, 20, 10, 1)',
                        'rgba(255, 40, 10, 1)',
                        'rgba(255, 60, 10, 1)',
                        'rgba(255, 80, 10, 1)',
                        'rgba(255, 100, 10, 1)',
                        'rgba(255, 120, 10, 1)',
                        'rgba(255, 140, 10, 1)',
                        'rgba(255, 160, 10, 1)',
                        'rgba(255, 180, 10, 1)',
                        'rgba(255, 200, 10, 1)',
                    ],
                }]
            },
            options: {
                maintainAspectRatio: false
            }
        });
    </script>
    <script>
        const ctxVentas = document.getElementById('ventasPorFecha').getContext('2d');
        const ventasChart = new Chart(ctxVentas, {
            type: 'line',
            data: {
                labels: {!! json_encode($stockMenorLista->pluck('nombre')) !!},
                datasets: [{
                    label: 'Ventas',
                    data: {!! json_encode($stockMenorLista->pluck('stock')) !!},
                    borderColor: 'rgba(255, 10, 150, 1)',
                    backgroundColor: 'rgba(255, 10, 150, 0.2)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        function actualizarHoraYFecha() {
            const ahora = new Date();
            const opcionesFecha = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const opcionesHora = {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };

            const fechaActual = ahora.toLocaleDateString('es-ES', opcionesFecha);
            const horaActual = ahora.toLocaleTimeString('es-ES', opcionesHora);

            document.getElementById('fechaActual').textContent = fechaActual;
            document.getElementById('horaActual').textContent = horaActual;
        }

        actualizarHoraYFecha();
        setInterval(actualizarHoraYFecha, 1000);
    </script>
@stop
