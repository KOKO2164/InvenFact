<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductosExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $categoria_id;
    protected $stock_min;

    public function __construct($categoria_id = null, $stock_min = null)
    {
        $this->categoria_id = $categoria_id;
        $this->stock_min = $stock_min;
    }

    public function query()
    {
        $query = Producto::query()->with('categoria');
        
        if ($this->categoria_id) {
            $query->where('categoria_id', $this->categoria_id);
        }
        
        if ($this->stock_min) {
            $query->where('stock', '<=', $this->stock_min);
        }
        
        return $query->orderBy('nombre');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Descripción',
            'Categoría',
            'Precio',
            'Stock',
            'Código de Ubicación',
            'Estado',
            'Valor en Inventario'
        ];
    }

    public function map($producto): array
    {
        return [
            $producto->id,
            $producto->nombre,
            $producto->descripcion,
            $producto->categoria->nombre,
            'S/ ' . number_format($producto->precio, 2),
            $producto->stock,
            $producto->codigoUbicacion,
            $producto->estado ? 'Activo' : 'Inactivo',
            'S/ ' . number_format($producto->precio * $producto->stock, 2)
        ];
    }

    public function title(): string
    {
        return 'Reporte de Productos';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}