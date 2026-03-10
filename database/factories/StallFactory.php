<?php

namespace Database\Factories;

use App\Models\FleaMarket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stall>
 */
class StallFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'flea_market_id' => FleaMarket::factory(),
            'user_id'        => User::factory(),
            'name'           => fake()->company(),
            'information'    => fake()->optional()->paragraph(),
            'home_delivery'  => fake()->boolean(40),
            'active'         => fake()->boolean(80),
            'img_url'        => fake()->optional()->imageUrl(400, 300, 'business'),
            'register_date'  => fake()->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
            'reset_date'     => fake()->optional()->dateTimeBetween('-1 year', 'now')?->format('Y-m-d'),
        ];
    }
}
