<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Estado;
use App\Models\Proveedor;
use App\Traits\ComplexTrait;

class CompraController extends Controller
{
    use ComplexTrait;

    protected $model = Compra::class;
    protected $searchField = 'codigo';
    protected $otherVariables = ['trabajadores'];
    protected function validationRules($id = null)
    {
        return [
            'codigo' => 'required|string|regex:/^C[0-9]{3}$/|unique:compras,codigo,' . $id,
            'proveedor_id' => 'required|integer|exists:proveedores,id',
            'trabajador_id' => 'required|integer|exists:users,id',
            'plazo' => 'required|integer|min:0|max:30',
        ];
    }
    protected function otherModels()
    {
        return [
            'proveedores' => Proveedor::class,
            'estados' => Estado::class,
        ];
    }
    protected function otherVariables()
    {
        $ultimoCodigoPedido = Compra::orderBy('codigo', 'desc')->first()->codigo ?? 'C000';
        return 'C' . str_pad((int)substr($ultimoCodigoPedido, 1) + 1, 3, '0', STR_PAD_LEFT);
    }
}
