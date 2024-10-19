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
            'nombre' => 'Proveedor A',
            'ruc' => '12345678901',
            'email' => 'contacto@proveedora.com',
            'telefono' => '987654321',
            'direccion' => 'Av. Principal 123, Lima, Perú',
            'estado' => true,
        ]);

        Proveedor::create([
            'nombre' => 'Proveedor B',
            'ruc' => '10987654321',
            'email' => 'info@proveedorb.com',
            'telefono' => '912345678',
            'direccion' => 'Calle Secundaria 456, Arequipa, Perú',
            'estado' => true,
        ]);

        Proveedor::create([
            'nombre' => 'Proveedor C',
            'ruc' => '11122334455',
            'email' => 'contacto@proveedorc.com',
            'telefono' => '930123456',
            'direccion' => 'Jr. Tercera 789, Cusco, Perú',
            'estado' => true,
        ]);

        Proveedor::create([
            'nombre' => 'Proveedor D',
            'ruc' => '22233445566',
            'email' => 'info@proveedord.com',
            'telefono' => '945678123',
            'direccion' => 'Av. Cuarta 321, Trujillo, Perú',
            'estado' => true,
        ]);

        Proveedor::create([
            'nombre' => 'Proveedor E',
            'ruc' => '33344556677',
            'email' => 'contacto@proveedore.com',
            'telefono' => '956789012',
            'direccion' => 'Calle Quinto 654, Piura, Perú',
            'estado' => true,
        ]);

        Proveedor::create([
            'nombre' => 'Proveedor F',
            'ruc' => '44455667788',
            'email' => 'info@proveedorf.com',
            'telefono' => '910987654',
            'direccion' => 'Jr. Sexto 543, Iquitos, Perú',
            'estado' => true,
        ]);

        Proveedor::create([
            'nombre' => 'Proveedor G',
            'ruc' => '55566778899',
            'email' => 'contacto@proveedorg.com',
            'telefono' => '921234567',
            'direccion' => 'Av. Séptima 432, Huancayo, Perú',
            'estado' => true,
        ]);

        Proveedor::create([
            'nombre' => 'Proveedor H',
            'ruc' => '66677889900',
            'email' => 'info@proveedorh.com',
            'telefono' => '934567890',
            'direccion' => 'Calle Octava 321, Cajamarca, Perú',
            'estado' => true,
        ]);

        Proveedor::create([
            'nombre' => 'Proveedor I',
            'ruc' => '77788990011',
            'email' => 'contacto@proveedori.com',
            'telefono' => '945678901',
            'direccion' => 'Jr. Noveno 987, Puno, Perú',
            'estado' => true,
        ]);

        Proveedor::create([
            'nombre' => 'Proveedor J',
            'ruc' => '88899001122',
            'email' => 'info@proveedorj.com',
            'telefono' => '956789012',
            'direccion' => 'Av. Décima 654, Tacna, Perú',
            'estado' => true,
        ]);
    }
}
