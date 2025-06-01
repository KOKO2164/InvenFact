<?php

namespace App\Exports;

use App\Models\Compra;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ComprasExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $fecha_desde;
    protected $fecha_hasta;
    protected $estado_id;

    public function __construct($fecha_desde = null, $fecha_hasta = null, $estado_id = null)
    {
        $this->fecha_desde = $fecha_desde;
        $this->fecha_hasta = $fecha_hasta;
        $this->estado_id = $estado_id;
    }

    public function query()
    {
        $query = Compra::query()->with(['proveedor', 'trabajador', 'estado']);
        
        if ($this->fecha_desde) {
            $query->whereDate('fecha', '>=', $this->fecha_desde);
        }
        
        if ($this->fecha_hasta) {
            $query->whereDate('fecha', '<=', $this->fecha_hasta);
        }
        
        if ($this->estado_id) {
            $query->where('estado_id', $this->estado_id);
        }
        
        return $query->orderBy('fecha', 'desc');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Código',
            'Proveedor',
            'Trabajador',
            'Fecha',
            'Estado',
            'Plazo (días)',
            'Total'
        ];
    }

    public function map($compra): array
    {
        return [
            $compra->id,
            $compra->codigo,
            $compra->proveedor->nombre,
            $compra->trabajador->name,
            $compra->fecha,
            $compra->estado->nombre,
            $compra->plazo,
            'S/ ' . number_format($compra->total, 2)
        ];
    }

    public function title(): string
    {
        return 'Reporte de Compras';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}