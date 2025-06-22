<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Proveedores</title>
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
        <h2>Reporte de Proveedores</h2>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Compras</th>
                <th>Total Vendido</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proveedores as $proveedor)
                <tr>
                    <td>{{ $proveedor->nombre }}</td>
                    <td>{{ $proveedor->compras_count }}</td>
                    <td>{{ number_format($proveedor->compras_sum_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
