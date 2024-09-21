<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::create([
            'nombre' => 'Administrador',
            'descripcion' => 'Administrador del sistema',
            'estado' => true
        ]);

        Rol::create([
            'nombre' => 'Trabajador',
            'descripcion' => 'Trabajador de la empresa',
            'estado' => true
        ]);
    }
}
