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
            ['user_id' => 2, 'stall_id' => 1, 'order_date' => Carbon::now()->subDays(3), 'delivery_date' => Carbon::now()->addDays(2), 'completed' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 7, 'stall_id' => 2, 'order_date' => Carbon::now()->subDays(2), 'delivery_date' => Carbon::now()->addDays(3), 'completed' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 1, 'stall_id' => 5, 'order_date' => Carbon::now()->subDay(), 'delivery_date' => null, 'completed' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 12, 'stall_id' => 6, 'order_date' => Carbon::now()->subDays(5), 'delivery_date' => Carbon::now()->subDay(), 'completed' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 14, 'stall_id' => 7, 'order_date' => Carbon::now(), 'delivery_date' => Carbon::now()->addDays(4), 'completed' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 15, 'stall_id' => 3, 'order_date' => Carbon::now()->subDays(4), 'delivery_date' => Carbon::now()->subDays(2), 'completed' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 17, 'stall_id' => 9, 'order_date' => Carbon::now()->subDay(), 'delivery_date' => Carbon::now()->addDays(5), 'completed' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 2, 'stall_id' => 4, 'order_date' => Carbon::now()->subDays(6), 'delivery_date' => null, 'completed' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('orders')->insert($orders);
    }
}
