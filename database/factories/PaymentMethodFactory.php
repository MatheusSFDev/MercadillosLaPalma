<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentMethod>
 */
class PaymentMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $methods = [
            'Efectivo',
            'Tarjeta',
            'Bizum',
            'Transferencia bancaria',
            'PayPal',
        ];

        return [
            'name' => fake()->unique()->randomElement($methods),
        ];
    }
}
