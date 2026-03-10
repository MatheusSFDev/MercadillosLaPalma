<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Municipality;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FleaMarket>
 */
class FleaMarketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address' => fake()->streetAddress(),
            'municipality_id' => Municipality::factory(),
            'img_url' => fake()->imageUrl(),
        ];
    }
}
