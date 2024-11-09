<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    use CommonTrait;

    protected $model = Producto::class;
    protected $searchField = 'nombre';
    protected function validationRules($id = null)
    {
        return [
            'nombre' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}0-9&\-\., ]+$/u|unique:productos,nombre,' . $id,
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'codigoUbicacion' => 'required|string|regex:/[A-Z]{2}[0-9]{2}/',
            'categoria_id' => 'required|numeric|exists:categorias,id'
        ];
    }
    protected function otherModels()
    {
        return ['categorias' => Categoria::class];
    }
}
