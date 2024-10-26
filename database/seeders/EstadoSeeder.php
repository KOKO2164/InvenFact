<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['nombre' => 'Pendiente'],
            ['nombre' => 'Aprobado'],
            ['nombre' => 'En proceso'],
            ['nombre' => 'Rechazado'],
            ['nombre' => 'Finalizado'],
        ];

        foreach ($estados as $estado) {
            \App\Models\Estado::create($estado);
        }
    }
}
