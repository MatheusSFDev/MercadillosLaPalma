<?php

namespace Database\Factories;

use App\Enums\Days;
use App\Models\FleaMarket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $openingHour = fake()->numberBetween(6, 11);
        $closingHour = fake()->numberBetween(13, 20);

        return [
            'flea_market_id' => FleaMarket::factory(),
            'day_of_week'    => fake()->randomElement(Days::cases())->value,
            'opening_time'   => sprintf('%02d:00:00', $openingHour),
            'closing_time'   => sprintf('%02d:00:00', $closingHour),
        ];
    }
}
