<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StockProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stockProducts = [
            [
                'product_id' => 1, // Carne de cerdo
                'stall_id' => 1,
                'quantity' => 50,
                'price_per_unit' => 6.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 2, // Pescado fresco
                'stall_id' => 2,
                'quantity' => 30,
                'price_per_unit' => 11.50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 3, // Frutas y verduras
                'stall_id' => 3,
                'quantity' => 100,
                'price_per_unit' => 3.25,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 4, // Artesanía local
                'stall_id' => 4,
                'quantity' => 15,
                'price_per_unit' => 22.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 5, // Productos varios
                'stall_id' => 2,
                'quantity' => 60,
                'price_per_unit' => 2.50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('stock_products')->insert($stockProducts);
    }
}
