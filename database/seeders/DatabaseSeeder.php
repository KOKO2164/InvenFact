<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Trabajador;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolSeeder::class);

        Trabajador::create([
            'nombre' => 'Rodrigo',
            'correo' => 'brrodrigo.2164@gmail.com',
            'contrasena' => Hash::make('12345678'),
            'rol_id' => 1,
            'estado' => true
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
