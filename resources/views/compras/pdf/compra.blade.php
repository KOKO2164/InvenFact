<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra #{{ $compra->codigo }}</title>
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
        <h2>Compra #{{ $compra->codigo }}</h2>
        <p>Proveedor: {{ $compra->proveedor->nombre ?? '' }}</p>
        <p>Fecha: {{ $compra->created_at->format('d/m/Y') }}</p>
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
            @foreach($compra->detalleCompras as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre ?? '' }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ number_format($detalle->precio, 2) }}</td>
                    <td>{{ number_format($detalle->cantidad * $detalle->precio, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p><strong>Total de la compra: </strong> S/ {{ number_format($compra->total, 2) }}</p>
</body>
</html>
