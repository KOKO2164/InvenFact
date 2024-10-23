<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create([
            'nombre' => 'Cemento',
            'descripcion' => 'Material utilizado en la construcción para la creación de concreto.',
        ]);

        Categoria::create([
            'nombre' => 'Ladrillos',
            'descripcion' => 'Bloques de arcilla cocida utilizados en la construcción de muros.',
        ]);

        Categoria::create([
            'nombre' => 'Aceros',
            'descripcion' => 'Productos de acero como vigas, varillas y estructuras metálicas.',
        ]);

        Categoria::create([
            'nombre' => 'Herramientas Manuales',
            'descripcion' => 'Herramientas como martillos, destornilladores y llaves utilizadas en obras.',
        ]);

        Categoria::create([
            'nombre' => 'Maderas',
            'descripcion' => 'Maderas tratadas para construcciones y estructuras.',
        ]);

        Categoria::create([
            'nombre' => 'Maquinaria Pesada',
            'descripcion' => 'Excavadoras, grúas y otros equipos industriales utilizados en obras.',
        ]);

        Categoria::create([
            'nombre' => 'Pinturas Industriales',
            'descripcion' => 'Pinturas y revestimientos utilizados en proyectos de construcción.',
        ]);

        Categoria::create([
            'nombre' => 'Herramientas Eléctricas',
            'descripcion' => 'Taladros, sierras eléctricas y otras herramientas alimentadas por electricidad.',
        ]);

        Categoria::create([
            'nombre' => 'Tubos y Conexiones',
            'descripcion' => 'Sistemas de tuberías para agua, gas y electricidad.',
        ]);

        Categoria::create([
            'nombre' => 'Impermeabilizantes',
            'descripcion' => 'Materiales utilizados para evitar la filtración de agua en estructuras.',
        ]);

        Categoria::create([
            'nombre' => 'Aislantes',
            'descripcion' => 'Materiales para aislamiento térmico y acústico en la construcción.',
        ]);

        Categoria::create([
            'nombre' => 'Sistemas de Andamios',
            'descripcion' => 'Estructuras temporales utilizadas para apoyar trabajos de construcción.',
        ]);
    }
}
