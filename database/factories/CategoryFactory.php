<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Frutas y verduras',
            'Ropa y calzado',
            'Artesanía',
            'Electrónica',
            'Alimentación',
            'Plantas y flores',
            'Juguetes',
            'Libros',
            'Joyería',
            'Hogar y decoración',
        ];

        return [
            'name' => fake()->unique()->randomElement($categories),
        ];
    }
}
