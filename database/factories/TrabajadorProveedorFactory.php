<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrabajadorProveedor>
 */
class TrabajadorProveedorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'telefono' => fake()->unique()->randomNumber(9),
            'proveedor_id' => Proveedor::inRandomOrder()->first()->id,
            'estado' => fake()->boolean()
        ];
    }
}
