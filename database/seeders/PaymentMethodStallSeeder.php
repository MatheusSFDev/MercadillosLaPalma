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
            ['payment_method_id' => 1, 'stall_id' => 1],
            ['payment_method_id' => 2, 'stall_id' => 1],
            ['payment_method_id' => 3, 'stall_id' => 2],
            ['payment_method_id' => 4, 'stall_id' => 2],
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
