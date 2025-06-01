<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for usuarios (users)
        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);

        // Create permissions for categorias
        Permission::create(['name' => 'ver categorias']);
        Permission::create(['name' => 'crear categorias']);
        Permission::create(['name' => 'editar categorias']);
        Permission::create(['name' => 'eliminar categorias']);

        // Create permissions for productos
        Permission::create(['name' => 'ver productos']);
        Permission::create(['name' => 'crear productos']);
        Permission::create(['name' => 'editar productos']);
        Permission::create(['name' => 'eliminar productos']);

        // Create permissions for clientes
        Permission::create(['name' => 'ver clientes']);
        Permission::create(['name' => 'crear clientes']);
        Permission::create(['name' => 'editar clientes']);
        Permission::create(['name' => 'eliminar clientes']);

        // Create permissions for proveedores
        Permission::create(['name' => 'ver proveedores']);
        Permission::create(['name' => 'crear proveedores']);
        Permission::create(['name' => 'editar proveedores']);
        Permission::create(['name' => 'eliminar proveedores']);

        // Create permissions for pedidos
        Permission::create(['name' => 'ver pedidos']);
        Permission::create(['name' => 'crear pedidos']);
        Permission::create(['name' => 'editar pedidos']);
        Permission::create(['name' => 'eliminar pedidos']);
        Permission::create(['name' => 'procesar pedidos']);

        // Create permissions for compras
        Permission::create(['name' => 'ver compras']);
        Permission::create(['name' => 'crear compras']);
        Permission::create(['name' => 'editar compras']);
        Permission::create(['name' => 'eliminar compras']);

        // Create permissions for reportes
        Permission::create(['name' => 'ver reportes']);
        Permission::create(['name' => 'generar reportes']);

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'Administrador']);
        $adminRole->givePermissionTo(Permission::all());

        $gerenteRole = Role::create(['name' => 'Gerente']);
        $gerenteRole->givePermissionTo([
            'ver usuarios', 'crear usuarios', 'editar usuarios',
            'ver categorias', 'crear categorias', 'editar categorias', 'eliminar categorias',
            'ver productos', 'crear productos', 'editar productos', 'eliminar productos',
            'ver clientes', 'crear clientes', 'editar clientes',
            'ver proveedores', 'crear proveedores', 'editar proveedores',
            'ver pedidos', 'crear pedidos', 'editar pedidos', 'procesar pedidos',
            'ver compras', 'crear compras', 'editar compras',
            'ver reportes', 'generar reportes'
        ]);

        $vendedorRole = Role::create(['name' => 'Vendedor']);
        $vendedorRole->givePermissionTo([
            'ver productos',
            'ver clientes', 'crear clientes', 'editar clientes',
            'ver pedidos', 'crear pedidos', 'editar pedidos',
            'ver reportes'
        ]);

        $almaceneroRole = Role::create(['name' => 'Almacenero']);
        $almaceneroRole->givePermissionTo([
            'ver productos', 'editar productos',
            'ver proveedores',
            'ver compras', 'crear compras', 'editar compras',
            'ver reportes'
        ]);

        // Create an admin user
        $admin = User::where('email', 'admin@invenfact.com')->first();
        
        if (!$admin) {
            $admin = User::factory()->create([
                'name' => 'Administrador',
                'email' => 'admin@invenfact.com',
                'password' => bcrypt('password'),
                'estado' => 1,
            ]);
        }
        
        $admin->assignRole('Administrador');
    }
}
