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
            'nombre' => 'required|string|max:255|regex:/^[a-zA-Z ]+$/',
            'email' => 'required|string|max:255',
            'direccion' => 'required|string|max:255|regex:/^[\p{L}\p{N}\-#°, ]+$/u',
            'telefono' => 'required|string|max:255|digits_between:7,9',
        ];
    }
    protected function otherModels()
    {
        return null;
    }
}
