<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['nombre' => 'Generado'],
            ['nombre' => 'Enviado'],
            ['nombre' => 'Aceptado'],
            ['nombre' => 'Rechazado'],
            ['nombre' => 'En proceso'],
            ['nombre' => 'En camino'],
            ['nombre' => 'Finalizado'],
        ];

        foreach ($estados as $estado) {
            Estado::create($estado);
        }
    }
}
