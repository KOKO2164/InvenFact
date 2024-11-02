<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Estado;
use App\Models\Pedido;
use App\Traits\ComplexTrait;

class PedidoController extends Controller
{
    use ComplexTrait;

    protected $model = Pedido::class;
    protected $searchField = 'codigo';
    protected $otherVariables = ['clientes'];
    protected function validationRules($id = null)
    {
        return [
            'codigo' => 'required|string|regex:/^P[0-9]{3}$/|unique:pedidos,codigo,' . $id,
            'cliente_id' => 'required|integer|exists:clientes,id',
            'trabajador_id' => 'required|integer|exists:users,id',
            'plazo' => 'required|integer|min:0|max:30',
        ];
    }
    protected function otherModels()
    {
        return [
            'clientes' => Cliente::class,
            'estados' => Estado::class,
        ];
    }
    protected function otherVariables()
    {
        $ultimoCodigoPedido = Pedido::orderBy('codigo', 'desc')->first()->codigo ?? 'P000';
        return 'P' . str_pad((int)substr($ultimoCodigoPedido, 1) + 1, 3, '0', STR_PAD_LEFT);
    }
}
