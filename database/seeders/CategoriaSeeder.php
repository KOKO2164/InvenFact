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
            'imagen' => 'images/categorias/cemento.jpg',
        ]);

        Categoria::create([
            'nombre' => 'Ladrillos',
            'descripcion' => 'Bloques de arcilla cocida utilizados en la construcción de muros.',
            'imagen' => 'images/categorias/ladrillos.jpg',
        ]);

        Categoria::create([
            'nombre' => 'Aceros',
            'descripcion' => 'Productos de acero como vigas, varillas y estructuras metálicas.',
            'imagen' => 'images/categorias/aceros.jpg',
        ]);

        Categoria::create([
            'nombre' => 'Herramientas Manuales',
            'descripcion' => 'Herramientas como martillos, destornilladores y llaves utilizadas en obras.',
            'imagen' => 'images/categorias/herramientas-manuales.jpg',
        ]);

        Categoria::create([
            'nombre' => 'Maderas',
            'descripcion' => 'Maderas tratadas para construcciones y estructuras.',
            'imagen' => 'images/categorias/maderas.jpg',
        ]);

        Categoria::create([
            'nombre' => 'Maquinaria Pesada',
            'descripcion' => 'Excavadoras, grúas y otros equipos industriales utilizados en obras.',
            'imagen' => 'images/categorias/maquinaria-pesada.jpg',
        ]);

        Categoria::create([
            'nombre' => 'Pinturas Industriales',
            'descripcion' => 'Pinturas y revestimientos utilizados en proyectos de construcción.',
            'imagen' => 'images/categorias/pinturas-industriales.jpg',
        ]);

        Categoria::create([
            'nombre' => 'Herramientas Eléctricas',
            'descripcion' => 'Taladros, sierras eléctricas y otras herramientas alimentadas por electricidad.',
            'imagen' => 'images/categorias/herramientas-electricas.jpg',
        ]);

        Categoria::create([
            'nombre' => 'Tubos y Conexiones',
            'descripcion' => 'Sistemas de tuberías para agua, gas y electricidad.',
            'imagen' => 'images/categorias/tubos-conexiones.jpg',
        ]);

        Categoria::create([
            'nombre' => 'Impermeabilizantes',
            'descripcion' => 'Materiales utilizados para evitar la filtración de agua en estructuras.',
            'imagen' => 'images/categorias/impermeabilizantes.jpg',
        ]);

        Categoria::create([
            'nombre' => 'Aislantes',
            'descripcion' => 'Materiales para aislamiento térmico y acústico en la construcción.',
            'imagen' => 'images/categorias/aislantes.jpg',
        ]);

        Categoria::create([
            'nombre' => 'Sistemas de Andamios',
            'descripcion' => 'Estructuras temporales utilizadas para apoyar trabajos de construcción.',
            'imagen' => 'images/categorias/andamios.jpg',
        ]);
    }

}
