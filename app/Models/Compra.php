<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras';
    protected $fillable = [
        'codigo',
        'trabajador_id',
        'proveedor_id',
        'trabajador_proveedor_id',
        'estado_id',
        'fecha',
        'plazo',
        'total',
        'cantidadProductos'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function trabajador()
    {
        return $this->belongsTo(User::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class);
    }
}
