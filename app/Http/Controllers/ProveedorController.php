<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProveedorController extends Controller
{
    use CommonTrait;

    protected $model = Proveedor::class;
    protected $searchField = 'nombre';
    protected function validationRules($id = null)
    {
        $rules = [
            'nombre' => 'required|string|regex:/^[a-zA-Z0-9&\- ]+$/',
            'ruc' => 'required|numeric|digits:11|unique:proveedores,ruc,' . $id,
            'email' => 'required|email|unique:proveedores,email,' . $id,
            'telefono' => 'required|numeric|digits_between:7,9',
            'direccion' => 'required|string|regex:/^[\p{L}\p{N}\-#°, ]+$/u'
        ];

        return $rules;
    }
    protected function otherModels()
    {
        return null;
    }
}
