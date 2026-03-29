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
            ['order_id' => 1, 'product_id' => 1, 'quantity' => 2, 'price_per_unit' => 8.50, 'status' => 'Pendiente'],
            ['order_id' => 1, 'product_id' => 2, 'quantity' => 1, 'price_per_unit' => 12.00, 'status' => 'Aceptado'],
            ['order_id' => 2, 'product_id' => 8, 'quantity' => 3, 'price_per_unit' => 3.50, 'status' => 'Pendiente'],
            ['order_id' => 2, 'product_id' => 10, 'quantity' => 2, 'price_per_unit' => 2.50, 'status' => 'Aceptado'],
            ['order_id' => 3, 'product_id' => 4, 'quantity' => 1, 'price_per_unit' => 15.00, 'status' => 'Pendiente'],
            ['order_id' => 3, 'product_id' => 6, 'quantity' => 1, 'price_per_unit' => 22.00, 'status' => 'Pendiente'],
            ['order_id' => 4, 'product_id' => 16, 'quantity' => 1, 'price_per_unit' => 16.50, 'status' => 'Aceptado'],
            ['order_id' => 4, 'product_id' => 18, 'quantity' => 1, 'price_per_unit' => 18.00, 'status' => 'Aceptado'],
            ['order_id' => 5, 'product_id' => 22, 'quantity' => 2, 'price_per_unit' => 3.00, 'status' => 'Pendiente'],
            ['order_id' => 5, 'product_id' => 23, 'quantity' => 1, 'price_per_unit' => 5.50, 'status' => 'Pendiente'],
            ['order_id' => 6, 'product_id' => 19, 'quantity' => 2, 'price_per_unit' => 6.00, 'status' => 'Aceptado'],
            ['order_id' => 6, 'product_id' => 21, 'quantity' => 1, 'price_per_unit' => 15.00, 'status' => 'Aceptado'],
            ['order_id' => 7, 'product_id' => 30, 'quantity' => 1, 'price_per_unit' => 8.00, 'status' => 'Pendiente'],
            ['order_id' => 7, 'product_id' => 31, 'quantity' => 2, 'price_per_unit' => 4.50, 'status' => 'Aceptado'],
            ['order_id' => 8, 'product_id' => 13, 'quantity' => 1, 'price_per_unit' => 25.00, 'status' => 'Aceptado'],
        ];

        DB::table('order_product')->insert($orderProducts);
    }
}