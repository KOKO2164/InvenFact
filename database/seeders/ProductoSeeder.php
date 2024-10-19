<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Productos para la categoría de "Cemento"
        Producto::create([
            'nombre' => 'Cemento Portland',
            'descripcion' => 'Cemento de alta resistencia ideal para la construcción.',
            'precio' => 10.50,
            'stock' => 200,
            'codigoUbicacion' => 'CP01',
            'imagen' => 'images/productos/cemento_portland.jpg',
            'estado' => true,
            'categoria_id' => 1, // ID de la categoría de Cemento
        ]);

        Producto::create([
            'nombre' => 'Cemento Rápido',
            'descripcion' => 'Cemento de fraguado rápido, ideal para reparaciones.',
            'precio' => 12.00,
            'stock' => 150,
            'codigoUbicacion' => 'CR02',
            'imagen' => 'images/productos/cemento_rapido.jpg',
            'estado' => true,
            'categoria_id' => 1,
        ]);

        Producto::create([
            'nombre' => 'Cemento Gris',
            'descripcion' => 'Cemento gris para obras generales.',
            'precio' => 9.00,
            'stock' => 250,
            'codigoUbicacion' => 'CG03',
            'imagen' => 'images/productos/cemento_gris.jpg',
            'estado' => true,
            'categoria_id' => 1,
        ]);

        // Productos para la categoría de "Ladrillos"
        Producto::create([
            'nombre' => 'Ladrillo Rojo',
            'descripcion' => 'Ladrillo cocido, ideal para construcción.',
            'precio' => 0.60,
            'stock' => 500,
            'codigoUbicacion' => 'LR01',
            'imagen' => 'images/productos/ladrillo_rojo.jpg',
            'estado' => true,
            'categoria_id' => 2, // ID de la categoría de Ladrillos
        ]);

        Producto::create([
            'nombre' => 'Ladrillo Ecológico',
            'descripcion' => 'Ladrillo ecológico hecho con materiales reciclados.',
            'precio' => 0.75,
            'stock' => 300,
            'codigoUbicacion' => 'LE02',
            'imagen' => 'images/productos/ladrillo_ecologico.jpg',
            'estado' => true,
            'categoria_id' => 2,
        ]);

        Producto::create([
            'nombre' => 'Ladrillo para Block',
            'descripcion' => 'Bloques de ladrillo para construcción de muros.',
            'precio' => 0.80,
            'stock' => 400,
            'codigoUbicacion' => 'LB03',
            'imagen' => 'images/productos/ladrillo_block.jpg',
            'estado' => true,
            'categoria_id' => 2,
        ]);

        // Productos para la categoría de "Aceros"
        Producto::create([
            'nombre' => 'Viga de Acero',
            'descripcion' => 'Viga de acero de 6 metros para soporte estructural.',
            'precio' => 150.00,
            'stock' => 50,
            'codigoUbicacion' => 'VA01',
            'imagen' => 'images/productos/viga_acero.jpg',
            'estado' => true,
            'categoria_id' => 3, // ID de la categoría de Aceros
        ]);

        Producto::create([
            'nombre' => 'Varilla de Acero',
            'descripcion' => 'Varilla de acero de 12 mm para reforzar estructuras.',
            'precio' => 0.90,
            'stock' => 300,
            'codigoUbicacion' => 'VA02',
            'imagen' => 'images/productos/varilla_acero.jpg',
            'estado' => true,
            'categoria_id' => 3,
        ]);

        Producto::create([
            'nombre' => 'Placa de Acero',
            'descripcion' => 'Placas de acero de alta resistencia para diferentes aplicaciones.',
            'precio' => 200.00,
            'stock' => 20,
            'codigoUbicacion' => 'PA03',
            'imagen' => 'images/productos/placa_acero.jpg',
            'estado' => true,
            'categoria_id' => 3,
        ]);

        // Productos para la categoría de "Herramientas Manuales"
        Producto::create([
            'nombre' => 'Martillo de Clavo',
            'descripcion' => 'Martillo de 16 oz para clavar y desclavar.',
            'precio' => 12.00,
            'stock' => 100,
            'codigoUbicacion' => 'MH01',
            'imagen' => 'images/productos/martillo_clavo.jpg',
            'estado' => true,
            'categoria_id' => 4, // ID de la categoría de Herramientas Manuales
        ]);

        Producto::create([
            'nombre' => 'Destornillador Phillips',
            'descripcion' => 'Destornillador con punta Phillips, 6 pulgadas.',
            'precio' => 5.00,
            'stock' => 150,
            'codigoUbicacion' => 'DP02',
            'imagen' => 'images/productos/destornillador_phillips.jpg',
            'estado' => true,
            'categoria_id' => 4,
        ]);

        Producto::create([
            'nombre' => 'Llave Inglesa',
            'descripcion' => 'Llave ajustable de 10 pulgadas.',
            'precio' => 8.00,
            'stock' => 75,
            'codigoUbicacion' => 'LI03',
            'imagen' => 'images/productos/llave_inglesa.jpg',
            'estado' => true,
            'categoria_id' => 4,
        ]);

        // Productos para la categoría de "Maderas"
        Producto::create([
            'nombre' => 'Tablero de Pino',
            'descripcion' => 'Tablero de pino de 2x4, 8 pies.',
            'precio' => 15.00,
            'stock' => 200,
            'codigoUbicacion' => 'TP01',
            'imagen' => 'images/productos/tablero_pino.jpg',
            'estado' => true,
            'categoria_id' => 5, // ID de la categoría de Maderas
        ]);

        Producto::create([
            'nombre' => 'Tronco de Madera',
            'descripcion' => 'Tronco de madera de roble, ideal para muebles.',
            'precio' => 50.00,
            'stock' => 30,
            'codigoUbicacion' => 'TM02',
            'imagen' => 'images/productos/tronco_madera.jpg',
            'estado' => true,
            'categoria_id' => 5,
        ]);

        Producto::create([
            'nombre' => 'Madera Contrachapada',
            'descripcion' => 'Madera contrachapada de 3/4, 4x8 pies.',
            'precio' => 40.00,
            'stock' => 100,
            'codigoUbicacion' => 'MC03',
            'imagen' => 'images/productos/madera_contrachapada.jpg',
            'estado' => true,
            'categoria_id' => 5,
        ]);

        // Productos para la categoría de "Maquinaria Pesada"
        Producto::create([
            'nombre' => 'Excavadora Caterpillar',
            'descripcion' => 'Excavadora de 20 toneladas, ideal para grandes obras.',
            'precio' => 50000.00,
            'stock' => 5,
            'codigoUbicacion' => 'EC01',
            'imagen' => 'images/productos/excavadora_caterpillar.jpg',
            'estado' => true,
            'categoria_id' => 6, // ID de la categoría de Maquinaria Pesada
        ]);

        Producto::create([
            'nombre' => 'Grúa Móvil',
            'descripcion' => 'Grúa móvil de 30 toneladas, perfecta para levantar cargas pesadas.',
            'precio' => 80000.00,
            'stock' => 3,
            'codigoUbicacion' => 'GM02',
            'imagen' => 'images/productos/grua_movil.jpg',
            'estado' => true,
            'categoria_id' => 6,
        ]);

        Producto::create([
            'nombre' => 'Retroexcavadora',
            'descripcion' => 'Retroexcavadora de 15 toneladas para excavación.',
            'precio' => 60000.00,
            'stock' => 4,
            'codigoUbicacion' => 'RE03',
            'imagen' => 'images/productos/retroexcavadora.jpg',
            'estado' => true,
            'categoria_id' => 6,
        ]);

        // Productos para la categoría de "Pinturas Industriales"
        Producto::create([
            'nombre' => 'Pintura Acrílica',
            'descripcion' => 'Pintura acrílica para exteriores, color azul.',
            'precio' => 25.00,
            'stock' => 100,
            'codigoUbicacion' => 'PA01',
            'imagen' => 'images/productos/pintura_acrilica.jpg',
            'estado' => true,
            'categoria_id' => 7, // ID de la categoría de Pinturas Industriales
        ]);

        Producto::create([
            'nombre' => 'Pintura Epóxica',
            'descripcion' => 'Pintura epóxica para pisos industriales, color gris.',
            'precio' => 30.00,
            'stock' => 50,
            'codigoUbicacion' => 'PE02',
            'imagen' => 'images/productos/pintura_epoxica.jpg',
            'estado' => true,
            'categoria_id' => 7,
        ]);

        Producto::create([
            'nombre' => 'Pintura a Base de Agua',
            'descripcion' => 'Pintura a base de agua, ideal para interiores.',
            'precio' => 22.00,
            'stock' => 80,
            'codigoUbicacion' => 'PA03',
            'imagen' => 'images/productos/pintura_base_agua.jpg',
            'estado' => true,
            'categoria_id' => 7,
        ]);

        // Productos para la categoría de "Herramientas Eléctricas"
        Producto::create([
            'nombre' => 'Taladro Inalámbrico',
            'descripcion' => 'Taladro inalámbrico con batería de 18V.',
            'precio' => 120.00,
            'stock' => 30,
            'codigoUbicacion' => 'TI01',
            'imagen' => 'images/productos/taladro_inalambrico.jpg',
            'estado' => true,
            'categoria_id' => 8, // ID de la categoría de Herramientas Eléctricas
        ]);

        Producto::create([
            'nombre' => 'Sierra Eléctrica',
            'descripcion' => 'Sierra eléctrica de banco, ideal para cortes precisos.',
            'precio' => 250.00,
            'stock' => 20,
            'codigoUbicacion' => 'SE02',
            'imagen' => 'images/productos/sierra_electrica.jpg',
            'estado' => true,
            'categoria_id' => 8,
        ]);

        Producto::create([
            'nombre' => 'Esmeriladora',
            'descripcion' => 'Esmeriladora de 5 pulgadas para pulir y cortar.',
            'precio' => 80.00,
            'stock' => 25,
            'codigoUbicacion' => 'ES03',
            'imagen' => 'images/productos/esmeriladora.jpg',
            'estado' => true,
            'categoria_id' => 8,
        ]);

        // Productos para la categoría de "Tubos y Conexiones"
        Producto::create([
            'nombre' => 'Tubo de PVC',
            'descripcion' => 'Tubo de PVC de 3 pulgadas, ideal para fontanería.',
            'precio' => 2.50,
            'stock' => 500,
            'codigoUbicacion' => 'TP01',
            'imagen' => 'images/productos/tubo_pvc.jpg',
            'estado' => true,
            'categoria_id' => 9, // ID de la categoría de Tubos y Conexiones
        ]);

        Producto::create([
            'nombre' => 'Conexión en "T"',
            'descripcion' => 'Conexión en "T" de PVC de 3 pulgadas.',
            'precio' => 1.50,
            'stock' => 400,
            'codigoUbicacion' => 'CT02',
            'imagen' => 'images/productos/conexion_T.jpg',
            'estado' => true,
            'categoria_id' => 9,
        ]);

        Producto::create([
            'nombre' => 'Tubo de Cobre',
            'descripcion' => 'Tubo de cobre de 1 pulgada para gas.',
            'precio' => 15.00,
            'stock' => 200,
            'codigoUbicacion' => 'TC03',
            'imagen' => 'images/productos/tubo_cobre.jpg',
            'estado' => true,
            'categoria_id' => 9,
        ]);

        // Productos para la categoría de "Impermeabilizantes"
        Producto::create([
            'nombre' => 'Impermeabilizante Líquido',
            'descripcion' => 'Impermeabilizante líquido para techos.',
            'precio' => 45.00,
            'stock' => 100,
            'codigoUbicacion' => 'IL01',
            'imagen' => 'images/productos/impermeabilizante_liquido.jpg',
            'estado' => true,
            'categoria_id' => 10, // ID de la categoría de Impermeabilizantes
        ]);

        Producto::create([
            'nombre' => 'Membrana Impermeabilizante',
            'descripcion' => 'Membrana impermeabilizante para superficies planas.',
            'precio' => 80.00,
            'stock' => 50,
            'codigoUbicacion' => 'MI02',
            'imagen' => 'images/productos/membrana_impermeabilizante.jpg',
            'estado' => true,
            'categoria_id' => 10,
        ]);

        Producto::create([
            'nombre' => 'Sellador Impermeabilizante',
            'descripcion' => 'Sellador impermeabilizante para grietas y juntas.',
            'precio' => 20.00,
            'stock' => 150,
            'codigoUbicacion' => 'SI03',
            'imagen' => 'images/productos/sellador_impermeabilizante.jpg',
            'estado' => true,
            'categoria_id' => 10,
        ]);

        // Productos para la categoría de "Aislantes"
        Producto::create([
            'nombre' => 'Aislante Térmico',
            'descripcion' => 'Aislante térmico para techos y paredes.',
            'precio' => 35.00,
            'stock' => 100,
            'codigoUbicacion' => 'AT01',
            'imagen' => 'images/productos/aislante_termico.jpg',
            'estado' => true,
            'categoria_id' => 11, // ID de la categoría de Aislantes
        ]);

        Producto::create([
            'nombre' => 'Aislante Acústico',
            'descripcion' => 'Aislante acústico para interiores.',
            'precio' => 30.00,
            'stock' => 80,
            'codigoUbicacion' => 'AA02',
            'imagen' => 'images/productos/aislante_acustico.jpg',
            'estado' => true,
            'categoria_id' => 11,
        ]);

        Producto::create([
            'nombre' => 'Panel Aislante',
            'descripcion' => 'Panel aislante para construcción.',
            'precio' => 50.00,
            'stock' => 70,
            'codigoUbicacion' => 'PA03',
            'imagen' => 'images/productos/panel_aislante.jpg',
            'estado' => true,
            'categoria_id' => 11,
        ]);

        // Productos para la categoría de "Sistemas de Andamios"
        Producto::create([
            'nombre' => 'Andamio de Aluminio',
            'descripcion' => 'Andamio de aluminio liviano para trabajos en altura.',
            'precio' => 150.00,
            'stock' => 20,
            'codigoUbicacion' => 'AA01',
            'imagen' => 'images/productos/andamio_aluminio.jpg',
            'estado' => true,
            'categoria_id' => 12, // ID de la categoría de Sistemas de Andamios
        ]);

        Producto::create([
            'nombre' => 'Andamio de Acero',
            'descripcion' => 'Andamio de acero robusto para construcción.',
            'precio' => 200.00,
            'stock' => 15,
            'codigoUbicacion' => 'AA02',
            'imagen' => 'images/productos/andamio_acero.jpg',
            'estado' => true,
            'categoria_id' => 12,
        ]);

        Producto::create([
            'nombre' => 'Escalera de Andamio',
            'descripcion' => 'Escalera de andamio de 2 metros para acceso.',
            'precio' => 75.00,
            'stock' => 25,
            'codigoUbicacion' => 'EA03',
            'imagen' => 'images/productos/escalera_andamio.jpg',
            'estado' => true,
            'categoria_id' => 12,
        ]);
    }
}
