<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedido #{{ $pedido->codigo }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 5px; text-align: left; }
        .table th { background: #f0f0f0; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Pedido #{{ $pedido->codigo }}</h2>
        <p>Cliente: {{ $pedido->cliente->nombre ?? '' }}</p>
        <p>Fecha: {{ $pedido->created_at->format('d/m/Y') }}</p>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->detallePedidos as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre ?? '' }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ number_format($detalle->precio, 2) }}</td>
                    <td>{{ number_format($detalle->cantidad * $detalle->precio, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p><strong>Total del pedido: </strong> S/ {{ number_format($pedido->total, 2) }}</p>
</body>
</html>
