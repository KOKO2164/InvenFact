<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\DetallePedido;
use App\Models\Estado;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatosPruebaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Borrar datos existentes para evitar duplicados
        $this->truncateTablas([
            'detalle_pedidos',
            'pedidos',
            'detalle_compras',
            'compras',
            'productos',
            'categorias',
            'proveedores',
            'clientes',
            'model_has_roles',
            'users'
        ]);

        // Verificar que existan los estados en la base de datos
        $this->verificarEstados();

        // Crear usuarios
        $this->crearUsuarios();

        // Crear clientes
        $this->crearClientes();

        // Crear proveedores
        $this->crearProveedores();

        // Crear categorías
        $this->crearCategorias();

        // Crear productos
        $this->crearProductos();

        // Crear compras
        $this->crearCompras();

        // Crear pedidos
        $this->crearPedidos();
    }

    private function truncateTablas(array $tablas)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tablas as $tabla) {
            DB::table($tabla)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function verificarEstados()
    {
        // Si no existen estados, crearlos
        if (Estado::count() === 0) {
            $estados = [
                ['id' => 1, 'nombre' => 'Nuevo'],
                ['id' => 2, 'nombre' => 'En proceso'],
                ['id' => 3, 'nombre' => 'En verificación'],
                ['id' => 4, 'nombre' => 'Cancelado'],
                ['id' => 5, 'nombre' => 'Verificado'],
                ['id' => 6, 'nombre' => 'Listo para entrega'],
                ['id' => 7, 'nombre' => 'Finalizado'],
            ];

            foreach ($estados as $estado) {
                Estado::create($estado);
            }
        }
    }

    private function crearUsuarios()
    {
        // Crear usuario administrador
        $adminUser = User::create([
            'name' => 'Administrador Principal',
            'dni' => '12345678',
            'fecha_nacimiento' => '1990-01-01',
            'email' => 'admin@invenfact.com',
            'password' => Hash::make('password'),
            'estado' => true
        ]);

        // Crear usuario vendedor
        $vendedorUser = User::create([
            'name' => 'Vendedor Principal',
            'dni' => '23456789',
            'fecha_nacimiento' => '1995-05-15',
            'email' => 'vendedor@invenfact.com',
            'password' => Hash::make('password'),
            'estado' => true
        ]);

        // Crear usuario almacenero
        $almaceneroUser = User::create([
            'name' => 'Almacenero Principal',
            'dni' => '34567890',
            'fecha_nacimiento' => '1985-10-20',
            'email' => 'almacenero@invenfact.com',
            'password' => Hash::make('password'),
            'estado' => true
        ]);

        // Asignar roles si existen
        $adminRole = Role::where('name', 'Administrador')->first();
        $vendedorRole = Role::where('name', 'Vendedor')->first();
        $almaceneroRole = Role::where('name', 'Almacenero')->first();

        if ($adminRole) {
            $adminUser->assignRole($adminRole);
        }

        if ($vendedorRole) {
            $vendedorUser->assignRole($vendedorRole);
        }

        if ($almaceneroRole) {
            $almaceneroUser->assignRole($almaceneroRole);
        }

        // Crear 7 usuarios adicionales
        User::factory()->count(7)->create();
    }

    private function crearClientes()
    {
        // Crear clientes de ejemplo para metalmecánica
        $clientes = [
            [
                'nombre' => 'Juan Pérez García',
                'email' => 'juan.perez@gmail.com',
                'direccion' => 'Jr. Los Olivos 123, Lima',
                'telefono' => '987654321',
                'estado' => true,
                'dni' => '12345678'
            ],
            [
                'nombre' => 'María López Torres',
                'email' => 'maria.lopez@hotmail.com',
                'direccion' => 'Av. Primavera 456, Surco',
                'telefono' => '912345678',
                'estado' => true,
                'dni' => '23456789'
            ],
            [
                'nombre' => 'Carlos Ramírez Soto',
                'email' => 'carlos.ramirez@yahoo.com',
                'direccion' => 'Calle Las Flores 789, Miraflores',
                'telefono' => '956789012',
                'estado' => true,
                'dni' => '34567890'
            ],
            [
                'nombre' => 'Ana Torres Quispe',
                'email' => 'ana.torres@gmail.com',
                'direccion' => 'Av. La Marina 321, Callao',
                'telefono' => '965432187',
                'estado' => true,
                'dni' => '45678901'
            ],
            [
                'nombre' => 'Luis Fernández Rojas',
                'email' => 'luis.fernandez@outlook.com',
                'direccion' => 'Jr. San Martín 654, Arequipa',
                'telefono' => '974563218',
                'estado' => true,
                'dni' => '56789012'
            ]
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }

        // Crear clientes adicionales usando factory
        Cliente::factory()->count(5)->create();
    }

    private function crearProveedores()
    {
        // Crear proveedores de ejemplo para metalmecánica
        $proveedores = [
            [
                'nombre' => 'Aceros del Perú S.A.',
                'ruc' => '20123456789',
                'email' => 'ventas@acerosperu.com',
                'telefono' => '955667788',
                'direccion' => 'Av. Argentina 3093, Callao',
                'estado' => true
            ],
            [
                'nombre' => 'Importadora de Metales RG',
                'ruc' => '20987654321',
                'email' => 'importaciones@metalesrg.com',
                'telefono' => '944556677',
                'direccion' => 'Av. Industrial 350, Lima',
                'estado' => true
            ],
            [
                'nombre' => 'Ferretería Industrial S.A.C',
                'ruc' => '20456789123',
                'email' => 'ventas@ferreteriaindustrial.com',
                'telefono' => '933445566',
                'direccion' => 'Av. Los Frutales 456, Santa Anita',
                'estado' => true
            ],
            [
                'nombre' => 'Distribuidora de Aceros Inoxidables',
                'ruc' => '20567891234',
                'email' => 'ventas@inoxidables.com',
                'telefono' => '922334455',
                'direccion' => 'Av. Canta Callao 789, San Martín de Porres',
                'estado' => true
            ],
            [
                'nombre' => 'Importación de Herramientas Técnicas',
                'ruc' => '20678912345',
                'email' => 'compras@herramientastec.com',
                'telefono' => '911223344',
                'direccion' => 'Av. Separadora Industrial 2580, Ate',
                'estado' => true
            ]
        ];

        foreach ($proveedores as $proveedor) {
            Proveedor::create($proveedor);
        }

        // Crear proveedores adicionales
        Proveedor::factory()->count(5)->create();
    }

    private function crearCategorias()
    {
        // Crear categorías de ejemplo para metalmecánica
        $categorias = [
            [
                'nombre' => 'Aceros',
                'descripcion' => 'Aceros estructurales y especiales',
                'estado' => true
            ],
            [
                'nombre' => 'Perfiles Metálicos',
                'descripcion' => 'Perfiles de diversos tipos y tamaños',
                'estado' => true
            ],
            [
                'nombre' => 'Herramientas',
                'descripcion' => 'Herramientas para trabajo en metal',
                'estado' => true
            ],
            [
                'nombre' => 'Soldadura',
                'descripcion' => 'Equipos y consumibles para soldadura',
                'estado' => true
            ],
            [
                'nombre' => 'Seguridad Industrial',
                'descripcion' => 'Equipos de protección personal',
                'estado' => true
            ],
            [
                'nombre' => 'Acabados',
                'descripcion' => 'Productos para el acabado de metales',
                'estado' => true
            ]
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }

    private function crearProductos()
    {
        // Obtener las categorías existentes
        $categorias = Categoria::all();

        // Crear productos de ejemplo para cada categoría
        foreach ($categorias as $categoria) {
            switch ($categoria->nombre) {
                case 'Aceros':
                    $productos = [
                        [
                            'nombre' => 'Plancha de Acero LAC 1/4"',
                            'descripcion' => 'Plancha de acero laminado en caliente de 1/4 pulgada',
                            'precio' => 450.90,
                            'stock' => 50,
                            'codigoUbicacion' => 'AC01'
                        ],
                        [
                            'nombre' => 'Barra Redonda 1"',
                            'descripcion' => 'Barra redonda de acero de 1 pulgada',
                            'precio' => 120.50,
                            'stock' => 100,
                            'codigoUbicacion' => 'AC02'
                        ],
                        [
                            'nombre' => 'Acero Inoxidable 304',
                            'descripcion' => 'Plancha de acero inoxidable calidad 304',
                            'precio' => 650.80,
                            'stock' => 30,
                            'codigoUbicacion' => 'AC03'
                        ]
                    ];
                    break;

                case 'Perfiles Metálicos':
                    $productos = [
                        [
                            'nombre' => 'Perfil Angular 2"x2"x1/4"',
                            'descripcion' => 'Perfil angular de 2x2 pulgadas x 1/4 de espesor',
                            'precio' => 85.50,
                            'stock' => 80,
                            'codigoUbicacion' => 'PM01'
                        ],
                        [
                            'nombre' => 'Tubo Cuadrado 2"x2"',
                            'descripcion' => 'Tubo de sección cuadrada de 2x2 pulgadas',
                            'precio' => 110.90,
                            'stock' => 60,
                            'codigoUbicacion' => 'PM02'
                        ],
                        [
                            'nombre' => 'Platina 3/16"x2"',
                            'descripcion' => 'Platina de acero de 3/16 x 2 pulgadas',
                            'precio' => 45.50,
                            'stock' => 120,
                            'codigoUbicacion' => 'PM03'
                        ]
                    ];
                    break;

                case 'Herramientas':
                    $productos = [
                        [
                            'nombre' => 'Esmeril Angular 4.5"',
                            'descripcion' => 'Esmeril angular de 4.5 pulgadas',
                            'precio' => 259.90,
                            'stock' => 15,
                            'codigoUbicacion' => 'HE01'
                        ],
                        [
                            'nombre' => 'Taladro Percutor Industrial',
                            'descripcion' => 'Taladro percutor de uso industrial',
                            'precio' => 420.00,
                            'stock' => 10,
                            'codigoUbicacion' => 'HE02'
                        ],
                        [
                            'nombre' => 'Juego de Brocas para Metal',
                            'descripcion' => 'Set de brocas para metal de 1/16" a 1/2"',
                            'precio' => 185.50,
                            'stock' => 25,
                            'codigoUbicacion' => 'HE03'
                        ]
                    ];
                    break;

                case 'Soldadura':
                    $productos = [
                        [
                            'nombre' => 'Electrodos E6011 3/32"',
                            'descripcion' => 'Caja de electrodos E6011 de 3/32 pulgadas',
                            'precio' => 75.90,
                            'stock' => 40,
                            'codigoUbicacion' => 'SO01'
                        ],
                        [
                            'nombre' => 'Máquina de Soldar Inverter 200A',
                            'descripcion' => 'Máquina de soldar tipo inverter de 200 amperios',
                            'precio' => 950.00,
                            'stock' => 5,
                            'codigoUbicacion' => 'SO02'
                        ],
                        [
                            'nombre' => 'Alambre MIG 0.8mm',
                            'descripcion' => 'Rollo de alambre para soldadura MIG de 0.8mm',
                            'precio' => 220.50,
                            'stock' => 15,
                            'codigoUbicacion' => 'SO03'
                        ]
                    ];
                    break;

                case 'Seguridad Industrial':
                    $productos = [
                        [
                            'nombre' => 'Careta de Soldar Fotosensible',
                            'descripcion' => 'Careta para soldar con filtro fotosensible',
                            'precio' => 185.90,
                            'stock' => 20,
                            'codigoUbicacion' => 'SI01'
                        ],
                        [
                            'nombre' => 'Guantes de Cuero para Soldador',
                            'descripcion' => 'Par de guantes de cuero reforzados para soldador',
                            'precio' => 45.50,
                            'stock' => 30,
                            'codigoUbicacion' => 'SI02'
                        ],
                        [
                            'nombre' => 'Zapatos de Seguridad con Punta de Acero',
                            'descripcion' => 'Zapatos de seguridad con punta reforzada',
                            'precio' => 120.90,
                            'stock' => 15,
                            'codigoUbicacion' => 'SI03'
                        ]
                    ];
                    break;

                case 'Acabados':
                    $productos = [
                        [
                            'nombre' => 'Pintura Anticorrosiva',
                            'descripcion' => 'Galón de pintura anticorrosiva para metal',
                            'precio' => 89.90,
                            'stock' => 25,
                            'codigoUbicacion' => 'AC01'
                        ],
                        [
                            'nombre' => 'Disco de Corte 4.5"',
                            'descripcion' => 'Disco de corte para metal de 4.5 pulgadas',
                            'precio' => 6.50,
                            'stock' => 100,
                            'codigoUbicacion' => 'AC02'
                        ],
                        [
                            'nombre' => 'Disco de Desbaste 7"',
                            'descripcion' => 'Disco de desbaste para metal de 7 pulgadas',
                            'precio' => 12.90,
                            'stock' => 80,
                            'codigoUbicacion' => 'AC03'
                        ]
                    ];
                    break;

                default:
                    $productos = [];
            }

            // Crear los productos para la categoría
            foreach ($productos as $producto) {
                Producto::create(array_merge($producto, [
                    'categoria_id' => $categoria->id,
                    'estado' => true
                ]));
            }
        }
    }

    private function crearCompras()
    {
        // Obtener proveedores
        $proveedores = Proveedor::all();

        // Obtener usuario almacenero
        $almacenero = User::where('email', 'almacenero@invenfact.com')->first();
        $userId = $almacenero ? $almacenero->id : User::first()->id;

        // Crear compras de ejemplo
        for ($i = 1; $i <= 5; $i++) {
            $compra = Compra::create([
                'codigo' => 'C' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'proveedor_id' => $proveedores->random()->id,
                'trabajador_id' => $userId,
                'estado_id' => rand(1, 7),
                'plazo' => rand(1, 30),
                'fecha' => now()->subDays(rand(1, 60)),
                'total' => 0
            ]);

            // Agregar detalles de compra
            $this->agregarDetalleCompra($compra);

            // Actualizar total
            $compra->update([
                'total' => $compra->detalleCompras->sum(function ($detalle) {
                    return $detalle->cantidad * $detalle->precio;
                })
            ]);
        }
    }

    private function agregarDetalleCompra($compra)
    {
        // Obtener productos aleatorios
        $productos = Producto::inRandomOrder()->take(rand(2, 5))->get();

        foreach ($productos as $producto) {
            DetalleCompra::create([
                'compra_id' => $compra->id,
                'producto_id' => $producto->id,
                'cantidad' => rand(5, 20),
                'precio' => $producto->precio * 0.7 // Precio de compra menor al de venta
            ]);
        }
    }

    private function crearPedidos()
    {
        // Obtener clientes
        $clientes = Cliente::all();

        // Obtener usuario vendedor
        $vendedor = User::where('email', 'vendedor@invenfact.com')->first();
        $userId = $vendedor ? $vendedor->id : User::first()->id;

        // Crear pedidos de ejemplo
        for ($i = 1; $i <= 8; $i++) {
            $pedido = Pedido::create([
                'codigo' => 'P' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'cliente_id' => $clientes->random()->id,
                'trabajador_id' => $userId,
                'estado_id' => rand(1, 7),
                'plazo' => rand(1, 15),
                'fecha' => now()->subDays(rand(1, 30)),
                'total' => 0
            ]);

            // Agregar detalles de pedido
            $this->agregarDetallePedido($pedido);

            // Actualizar total
            $pedido->update([
                'total' => $pedido->detallePedidos->sum(function ($detalle) {
                    return $detalle->cantidad * $detalle->precio;
                })
            ]);
        }
    }

    private function agregarDetallePedido($pedido)
    {
        // Obtener productos aleatorios
        $productos = Producto::inRandomOrder()->take(rand(2, 5))->get();

        foreach ($productos as $producto) {
            DetallePedido::create([
                'pedido_id' => $pedido->id,
                'producto_id' => $producto->id,
                'cantidad' => rand(1, 10),
                'precio' => $producto->precio
            ]);
        }
    }
}
