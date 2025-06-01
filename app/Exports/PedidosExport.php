<?php

namespace App\Exports;

use App\Models\Pedido;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PedidosExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithStyles
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
        $query = Pedido::query()->with(['cliente', 'trabajador', 'estado']);
        
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
            'Cliente',
            'Trabajador',
            'Fecha',
            'Estado',
            'Plazo (días)',
            'Total'
        ];
    }

    public function map($pedido): array
    {
        return [
            $pedido->id,
            $pedido->codigo,
            $pedido->cliente->nombre,
            $pedido->trabajador->name,
            $pedido->fecha,
            $pedido->estado->nombre,
            $pedido->plazo,
            'S/ ' . number_format($pedido->total, 2)
        ];
    }

    public function title(): string
    {
        return 'Reporte de Pedidos';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}