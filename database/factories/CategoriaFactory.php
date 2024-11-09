<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->randomElement([
                'Cemento',
                'Ladrillos',
                'Aceros',
                'Herramientas Manuales',
                'Maderas',
                'Maquinaria Pesada',
                'Pinturas Industriales',
                'Herramientas Eléctricas',
                'Tubos y Conexiones',
                'Sistemas de Andamios',
            ]),
            'descripcion' => $this->faker->sentence(),
        ];
    }
}
