<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HolydaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $holydays = [
            [
                'flea_market_id' => 1,
                'start_date' => now()->addDays(7),
                'end_date' => now()->addDays(14),
            ],
            [
                'flea_market_id' => 1,
                'start_date' => now()->addDays(30),
                'end_date' => now()->addDays(37),
            ],
            [
                'flea_market_id' => 1,
                'start_date' => now()->addDays(60),
                'end_date' => now()->addDays(67),
            ],
            [
                'flea_market_id' => 1,
                'start_date' => now()->addDays(90),
                'end_date' => now()->addDays(97),
            ],
        ];

        foreach ($holydays as $holyday) {
            DB::table('holidays')->insert([
                'flea_market_id' => $holyday['flea_market_id'],
                'start_date' => $holyday['start_date'],
                'end_date' => $holyday['end_date'],
            ]);
        }
    }
}
