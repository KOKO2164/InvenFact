<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Compras</title>
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
        <h2>Reporte de Compras</h2>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Proveedor</th>
                <th>Trabajador</th>
                <th>Fecha</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compras as $compra)
                <tr>
                    <td>{{ $compra->codigo }}</td>
                    <td>{{ $compra->proveedor->nombre ?? '' }}</td>
                    <td>{{ $compra->trabajador->name ?? '' }}</td>
                    <td>{{ $compra->fecha }}</td>
                    <td>{{ number_format($compra->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
