<?php

namespace App\Exports;

use App\Models\Proveedor;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProveedoresExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithStyles
{
    public function query()
    {
        return Proveedor::query()
            ->withCount('compras')
            ->withSum('compras', 'total')
            ->orderBy('nombre');
    }

    public function headings(): array
    {
        return [
            'ID',
            'RUC',
            'Nombre',
            'Email',
            'Teléfono',
            'Dirección',
            'Estado',
            'Total Compras',
            'Monto Total'
        ];
    }

    public function map($proveedor): array
    {
        return [
            $proveedor->id,
            $proveedor->ruc,
            $proveedor->nombre,
            $proveedor->email,
            $proveedor->telefono,
            $proveedor->direccion,
            $proveedor->estado ? 'Activo' : 'Inactivo',
            $proveedor->compras_count,
            'S/ ' . number_format($proveedor->compras_sum_total, 2)
        ];
    }

    public function title(): string
    {
        return 'Reporte de Proveedores';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}