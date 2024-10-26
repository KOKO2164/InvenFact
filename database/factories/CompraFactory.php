<?php

namespace Database\Factories;

use App\Models\Estado;
use App\Models\Proveedor;
use App\Models\TrabajadorProveedor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Compra>
 */
class CompraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $proveedorId = Proveedor::where('estado', 1)->inRandomOrder()->first()->id;
        return [
            'codigo' => $this->faker->unique()->regexify('[C]{1}[0-9]{3}'),
            'trabajador_id' => User::inRandomOrder()->first()->id,
            'proveedor_id' => $proveedorId,
            'trabajador_proveedor_id' => TrabajadorProveedor::where('proveedor_id', $proveedorId)->inRandomOrder()->first()->id,
            'estado_id' => Estado::inRandomOrder()->first()->id,
            'fecha' => $this->faker->dateTimeThisYear(),
            'plazo' => $this->faker->numberBetween(0, 30),
            'total' => $this->faker->randomFloat(2, 0, 1000),
            'cantidadProductos' => $this->faker->numberBetween(1, 100),
        ];
    }
}
