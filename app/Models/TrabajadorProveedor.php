<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrabajadorProveedor extends Model
{
    use HasFactory;

    protected $table = 'trabajador_proveedores';
    protected $fillable = [
        'nombre',
        'telefono',
        'proveedor_id',
        'estado'
    ];
    public $timestamps = false;

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}
