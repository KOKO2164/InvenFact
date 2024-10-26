<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    const PENDIENTE = 1;
    const APROBADO = 2;
    const EN_PROCESO = 3;
    const RECHAZADO = 4;
    const FINALIZADO = 5;

    protected $table = 'estados';
    protected $fillable = ['nombre'];
    public $timestamps = false;

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}
