<?php

namespace Database\Factories;

use App\Models\Stall;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $orderDate = fake()->dateTimeBetween('-1 year', 'now');
        $deliveryDate = fake()->dateTimeBetween($orderDate, '+1 month');

        return [
            'user_id'       => User::factory(),
            'stall_id'      => Stall::factory(),
            'order_date'    => $orderDate->format('Y-m-d'),
            'delivery_date' => $deliveryDate->format('Y-m-d'),
            'completed'     => fake()->boolean(30),
        ];
    }
}
