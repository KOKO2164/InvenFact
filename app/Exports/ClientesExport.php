<?php

namespace App\Exports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientesExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithStyles
{
    public function query()
    {
        return Cliente::query()
            ->withCount('pedidos')
            ->withSum('pedidos', 'total')
            ->orderBy('nombre');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'DNI',
            'Email',
            'Teléfono',
            'Dirección',
            'Estado',
            'Total Pedidos',
            'Monto Total'
        ];
    }

    public function map($cliente): array
    {
        return [
            $cliente->id,
            $cliente->nombre,
            $cliente->dni,
            $cliente->email,
            $cliente->telefono,
            $cliente->direccion,
            $cliente->estado ? 'Activo' : 'Inactivo',
            $cliente->pedidos_count,
            'S/ ' . number_format($cliente->pedidos_sum_total, 2)
        ];
    }

    public function title(): string
    {
        return 'Reporte de Clientes';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}