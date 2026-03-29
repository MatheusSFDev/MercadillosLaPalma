<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductStallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stockProducts = [
            ['product_id' => 1, 'stall_id' => 1, 'quantity' => 50, 'price_per_unit' => 8.50, 'min_quantity' => 0.5, 'step_quantity' => 0.25, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 2, 'stall_id' => 1, 'quantity' => 30, 'price_per_unit' => 12.00, 'min_quantity' => 0.5, 'step_quantity' => 0.25, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 3, 'stall_id' => 1, 'quantity' => 20, 'price_per_unit' => 14.00, 'min_quantity' => 0.25, 'step_quantity' => 0.25, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 7, 'stall_id' => 2, 'quantity' => 200, 'price_per_unit' => 1.80, 'min_quantity' => 0.5, 'step_quantity' => 0.5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 8, 'stall_id' => 2, 'quantity' => 80, 'price_per_unit' => 3.50, 'min_quantity' => 0.5, 'step_quantity' => 0.5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 9, 'stall_id' => 2, 'quantity' => 100, 'price_per_unit' => 2.80, 'min_quantity' => 1, 'step_quantity' => 0.5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 10, 'stall_id' => 2, 'quantity' => 120, 'price_per_unit' => 2.50, 'min_quantity' => 0.5, 'step_quantity' => 0.5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 11, 'stall_id' => 2, 'quantity' => 60, 'price_per_unit' => 2.20, 'min_quantity' => 1, 'step_quantity' => 0.5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 19, 'stall_id' => 3, 'quantity' => 40, 'price_per_unit' => 6.00, 'min_quantity' => 1, 'step_quantity' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 20, 'stall_id' => 3, 'quantity' => 50, 'price_per_unit' => 5.00, 'min_quantity' => 1, 'step_quantity' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 21, 'stall_id' => 3, 'quantity' => 20, 'price_per_unit' => 15.00, 'min_quantity' => 1, 'step_quantity' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 13, 'stall_id' => 4, 'quantity' => 15, 'price_per_unit' => 25.00, 'min_quantity' => 1, 'step_quantity' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 14, 'stall_id' => 4, 'quantity' => 100, 'price_per_unit' => 8.00, 'min_quantity' => 1, 'step_quantity' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 15, 'stall_id' => 4, 'quantity' => 10, 'price_per_unit' => 35.00, 'min_quantity' => 1, 'step_quantity' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 4, 'stall_id' => 5, 'quantity' => 40, 'price_per_unit' => 15.00, 'min_quantity' => 0.5, 'step_quantity' => 0.25, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 5, 'stall_id' => 5, 'quantity' => 20, 'price_per_unit' => 18.00, 'min_quantity' => 0.5, 'step_quantity' => 0.25, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 6, 'stall_id' => 5, 'quantity' => 15, 'price_per_unit' => 22.00, 'min_quantity' => 0.25, 'step_quantity' => 0.25, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 16, 'stall_id' => 6, 'quantity' => 25, 'price_per_unit' => 16.50, 'min_quantity' => 0.25, 'step_quantity' => 0.25, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 17, 'stall_id' => 6, 'quantity' => 30, 'price_per_unit' => 12.00, 'min_quantity' => 0.25, 'step_quantity' => 0.25, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 18, 'stall_id' => 6, 'quantity' => 20, 'price_per_unit' => 18.00, 'min_quantity' => 0.25, 'step_quantity' => 0.25, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 22, 'stall_id' => 7, 'quantity' => 50, 'price_per_unit' => 3.00, 'min_quantity' => 1, 'step_quantity' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 23, 'stall_id' => 7, 'quantity' => 60, 'price_per_unit' => 5.50, 'min_quantity' => 1, 'step_quantity' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 24, 'stall_id' => 7, 'quantity' => 40, 'price_per_unit' => 2.50, 'min_quantity' => 1, 'step_quantity' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 28, 'stall_id' => 8, 'quantity' => 30, 'price_per_unit' => 12.00, 'min_quantity' => 1, 'step_quantity' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 29, 'stall_id' => 8, 'quantity' => 25, 'price_per_unit' => 9.50, 'min_quantity' => 1, 'step_quantity' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 30, 'stall_id' => 9, 'quantity' => 20, 'price_per_unit' => 8.00, 'min_quantity' => 0.25, 'step_quantity' => 0.25, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 31, 'stall_id' => 9, 'quantity' => 40, 'price_per_unit' => 4.50, 'min_quantity' => 1, 'step_quantity' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 12, 'stall_id' => 10, 'quantity' => 50, 'price_per_unit' => 12.00, 'min_quantity' => 0.5, 'step_quantity' => 0.5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 10, 'stall_id' => 10, 'quantity' => 40, 'price_per_unit' => 2.50, 'min_quantity' => 0.5, 'step_quantity' => 0.5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 27, 'stall_id' => 11, 'quantity' => 40, 'price_per_unit' => 10.00, 'min_quantity' => 1, 'step_quantity' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 9, 'stall_id' => 12, 'quantity' => 80, 'price_per_unit' => 3.00, 'min_quantity' => 1, 'step_quantity' => 0.5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 8, 'stall_id' => 12, 'quantity' => 60, 'price_per_unit' => 3.80, 'min_quantity' => 0.5, 'step_quantity' => 0.5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 14, 'stall_id' => 13, 'quantity' => 80, 'price_per_unit' => 7.50, 'min_quantity' => 1, 'step_quantity' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 26, 'stall_id' => 13, 'quantity' => 30, 'price_per_unit' => 6.00, 'min_quantity' => 1, 'step_quantity' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 25, 'stall_id' => 13, 'quantity' => 25, 'price_per_unit' => 8.00, 'min_quantity' => 1, 'step_quantity' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['product_id' => 7, 'stall_id' => 14, 'quantity' => 150, 'price_per_unit' => 1.90, 'min_quantity' => 0.5, 'step_quantity' => 0.5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('product_stall')->insert($stockProducts);
    }
}
