<?php

namespace App\Http\Controllers;

use App\Traits\CommonTrait;

class ClienteController extends Controller
{
    use CommonTrait;

    protected $model = \App\Models\Cliente::class;
    protected $searchField = 'nombre';
    protected function validationRules()
    {
        return [
            'nombre' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}0-9&\-\'\., ]+$/u',
            'email' => 'required|string|max:255',
            'direccion' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}\p{N}\-#°,\'\. ]+$/u',
            'telefono' => 'required|string|regex:/^[0-9\-\+ ]+$/|min:9|max:15',
        ];
    }
    protected function otherModels()
    {
        return null;
    }
}
