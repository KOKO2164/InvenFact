<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->words(3, true),
            'descripcion' => $this->faker->sentence(),
            'precio' => $this->faker->randomFloat(2, 0.50, 1000.00),
            'stock' => $this->faker->numberBetween(10, 1000),
            'codigoUbicacion' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{2}'),
            'estado' => $this->faker->boolean(),
            'categoria_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
