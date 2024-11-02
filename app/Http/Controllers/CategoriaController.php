<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriaController extends Controller
{
    use CommonTrait;

    protected $model = Categoria::class;
    protected $searchField = 'nombre';
    protected function validationRules($id = null)
    {
        return [
            'nombre' => 'required|string|regex:/^[a-zA-Z0-9&\- ]+$/|unique:categorias,nombre,' . $id,
            'descripcion' => 'required|string'
        ];
    }
    protected function otherModels()
    {
        return null;
    }
}
