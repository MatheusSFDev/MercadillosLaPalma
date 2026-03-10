<?php

namespace Database\Factories;

use App\Enums\Units;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'category_id' => Category::factory(),
            'name'        => fake()->words(fake()->numberBetween(1, 3), true),
            'unit'        => fake()->randomElement(Units::cases())->value,
        ];
    }
}
