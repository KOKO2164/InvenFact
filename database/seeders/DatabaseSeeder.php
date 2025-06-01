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
        // Verificar si se quiere usar el seeder de datos de prueba completo
        if (env('USE_TEST_DATA', false)) {
            // Primero ejecutamos el seeder de roles y permisos
            $this->call(RolePermissionSeeder::class);
            
            // Luego ejecutamos el seeder de datos de prueba completo
            $this->call(DatosPruebaSeeder::class);
        } else {
            // Ejecutar los seeders individuales (comportamiento original)
            // Run our new role and permission seeder
            $this->call(RolePermissionSeeder::class);
            
            // Call other seeders
            $this->call(ProveedorSeeder::class);
            $this->call(ClienteSeeder::class);
            $this->call(CategoriaSeeder::class);
            $this->call(ProductoSeeder::class);

            // Create admin user if doesn't exist
            $admin = User::where('email', 'brrodrigo.2164@gmail.com')->first();
            
            if (!$admin) {
                $admin = User::create([
                    'name' => 'Rodrigo Bohorquez',
                    'dni' => '76407729',
                    'fecha_nacimiento' => '2004-06-21',
                    'email' => 'brrodrigo.2164@gmail.com',
                    'password' => bcrypt('12345678'),
                    'estado' => true
                ]);
                
                // Assign administrator role to this user
                $admin->assignRole('Administrador');
            }

            $this->call(UserSeeder::class);
            $this->call(EstadoSeeder::class);
        }
    }
}
