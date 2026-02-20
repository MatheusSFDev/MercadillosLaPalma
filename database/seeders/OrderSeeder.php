<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = [
            [
                'user_id' => 1,
                'stall_id' => 1,
                'order_date' => Carbon::now()->subDays(5),
                'delivery_date' => Carbon::now()->addDays(2),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'completed' => false,
            ],
            [
                'user_id' => 2,
                'stall_id' => 2,
                'order_date' => Carbon::now()->subDays(3),
                'delivery_date' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'completed' => false,
            ],
            [
                'user_id' => 1,
                'stall_id' => 3,
                'order_date' => Carbon::now()->subDay(),
                'delivery_date' => Carbon::now()->addDays(5),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'completed' => false,
            ],
        ];

        DB::table('orders')->insert($orders);
    }
}
