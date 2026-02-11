<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderProducts = [
            [
                'order_id' => 1,
                'product_id' => 1,
                'quantity' => 2,
                'price_per_unit' => 5.50,
                'status' => 'Pendiente',
            ],
            [
                'order_id' => 1,
                'product_id' => 2,
                'quantity' => 1,
                'price_per_unit' => 12.00,
                'status' => 'Aceptado',
            ],
            [
                'order_id' => 2,
                'product_id' => 3,
                'quantity' => 3,
                'price_per_unit' => 3.75,
                'status' => 'Pendiente',
            ],
            [
                'order_id' => 3,
                'product_id' => 4,
                'quantity' => 1,
                'price_per_unit' => 20.00,
                'status' => 'Completado',
            ],
            [
                'order_id' => 3,
                'product_id' => 5,
                'quantity' => 5,
                'price_per_unit' => 2.00,
                'status' => 'Aceptado',
            ],
        ];

        DB::table('order_product')->insert($orderProducts);
    }
}