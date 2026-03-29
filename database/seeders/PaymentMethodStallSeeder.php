<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodStallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethodStalls = [
            [
                'payment_method_id' => 1,
                'stall_id' => 1,
            ],
            [
                'payment_method_id' => 4,
                'stall_id' => 1,
            ],
            [
                'payment_method_id' => 4,
                'stall_id' => 2,
            ],
            [
                'payment_method_id' => 1,
                'stall_id' => 3,
            ],
            [
                'payment_method_id' => 4,
                'stall_id' => 3,
            ],
            [
                'payment_method_id' => 4,
                'stall_id' => 4,
            ],
            [
                'payment_method_id' => 1,
                'stall_id' => 5,
            ],
            [
                'payment_method_id' => 4,
                'stall_id' => 5,
            ],
            [
                'payment_method_id' => 4,
                'stall_id' => 6,
            ],
            [
                'payment_method_id' => 3,
                'stall_id' => 6,
            ],
            [
                'payment_method_id' => 4,
                'stall_id' => 7,
            ],
            [
                'payment_method_id' => 1,
                'stall_id' => 8,
            ],
            [
                'payment_method_id' => 3,
                'stall_id' => 8,
            ],
            [
                'payment_method_id' => 4,
                'stall_id' => 8,
            ],
            [
                'payment_method_id' => 4,
                'stall_id' => 9,
            ],
            [
                'payment_method_id' => 4,
                'stall_id' => 10,
            ],
            [
                'payment_method_id' => 1,
                'stall_id' => 11,
            ],
            [
                'payment_method_id' => 3,
                'stall_id' => 11,
            ],
            [
                'payment_method_id' => 4,
                'stall_id' => 12,
            ],
            [
                'payment_method_id' => 4,
                'stall_id' => 13,
            ],
            [
                'payment_method_id' => 4,
                'stall_id' => 14,
            ],
        ];
        foreach ($paymentMethodStalls as $methodStall) {
            DB::table('payment_method_stall')->insert(
                [
                    'payment_method_id' => $methodStall['payment_method_id'],
                    'stall_id' => $methodStall['stall_id'],
                ]
            );
        }
    }
}
