<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolSeeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(ProductoSeeder::class);

        User::create([
            'name' => 'Rodrigo Bohorquez',
            'dni' => '76407729',
            'fecha_nacimiento' => '2004-06-21',
            'email' => 'brrodrigo.2164@gmail.com',
            'password' => bcrypt('12345678'),
            'rol_id' => 1,
            'estado' => true
        ]);

        $this->call(UserSeeder::class);
        $this->call(EstadoSeeder::class);
    }
}
