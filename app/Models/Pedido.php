<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'codigo',
        'trabajador_id',
        'cliente_id',
        'estado_id',
        'fecha',
        'plazo',
        'total',
        'cantidadProductos',
    ];

    public function trabajador()
    {
        return $this->belongsTo(User::class, 'trabajador_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function detallePedidos()
    {
        return $this->hasMany(DetallePedido::class);
    }
}
