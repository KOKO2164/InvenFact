<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Proveedor::create([
            'nombre' => 'Proveedor 1',
            'ruc' => '11112222333',
            'email' => 'proveedor1@pro.com',
            'telefono' => '999111333',
            'direccion' => 'Av. 1 de Mayo'
        ]);
    }
}
