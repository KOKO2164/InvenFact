<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias'; 
    protected $fillable = ["nombre", "descripcion", "imagen", "estado"];
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
