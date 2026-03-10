<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Municipality>
 */
class MunicipalityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $municipalities = [
            'Santa Cruz de La Palma',
            'Los Llanos de Aridane',
            'El Paso',
            'Breña Alta',
            'Breña Baja',
            'Mazo',
            'Fuencaliente',
            'Villa de Mazo',
            'Tijarafe',
            'Puntagorda',
            'Garafía',
            'Barlovento',
            'San Andrés y Sauces',
            'Puntallana',
            'Tazacorte',
        ];

        return [
            'name' => fake()->unique()->randomElement($municipalities),
        ];
    }
}
