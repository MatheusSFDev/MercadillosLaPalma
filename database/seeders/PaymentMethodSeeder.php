<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            ['name' => 'Credit Card'],
            ['name' => 'PayPal'],
            ['name' => 'Bank Transfer'],
            ['name' => 'Cash on Delivery'],
        ];

        foreach ($paymentMethods as $method) {
            DB::table('payment_methods')->insert(
                [
                    'name' => $method['name'],
                ]
            );
        }
    }
}
