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
        return [
            'nombre' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}0-9&\-\'\., ]+$/u',
            'ruc' => 'required|numeric|digits:11|unique:proveedores,ruc,' . $id,
            'email' => 'required|email|unique:proveedores,email,' . $id,
            'telefono' => 'required|string|regex:/^[0-9\-\+ ]+$/|min:9|max:15',
            'direccion' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}\p{N}\-#°,\'\. ]+$/u'
        ];
    }
    protected function otherModels()
    {
        return null;
    }
}
