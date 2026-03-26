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
                'end_date' => now()->addDays(32),
            ],
            [
                'flea_market_id' => 1,
                'start_date' => now()->addDays(60),
                'end_date' => now()->addDays(63),
            ],
            [
                'flea_market_id' => 2,
                'start_date' => now()->addDays(90),
                'end_date' => now()->addDays(91),
            ],
            [
                'flea_market_id' => 2,
                'start_date' => now()->addDays(120),
                'end_date' => now()->addDays(130),
            ],
            [
                'flea_market_id' => 3,
                'start_date' => now()->addDays(150),
                'end_date' => now()->addDays(157),
            ],
            [
                'flea_market_id' => 3,
                'start_date' => now()->addDays(180),
                'end_date' => now()->addDays(184),
            ],
            [
                'flea_market_id' => 4,
                'start_date' => now()->addDays(210),
                'end_date' => now()->addDays(213),
            ],
            [
                'flea_market_id' => 4,
                'start_date' => now()->addDays(240),
                'end_date' => now()->addDays(245),
            ],
            [
                'flea_market_id' => 5,
                'start_date' => now()->addDays(272),
                'end_date' => now()->addDays(275),
            ],
            [
                'flea_market_id' => 5,
                'start_date' => now()->addDays(300),
                'end_date' => now()->addDays(301),
            ],
            [
                'flea_market_id' => 6,
                'start_date' => now()->addDays(330),
                'end_date' => now()->addDays(331),
            ],
            [
                'flea_market_id' => 6,
                'start_date' => now()->addDays(360),
                'end_date' => now()->addDays(362),
            ],
            [
                'flea_market_id' => 7,
                'start_date' => now()->addDays(400),
                'end_date' => now()->addDays(404),
            ],
            [
                'flea_market_id' => 7,
                'start_date' => now()->addDays(450),
                'end_date' => now()->addDays(451),
            ],
            [
                'flea_market_id' => 8,
                'start_date' => now()->addDays(500),
                'end_date' => now()->addDays(505),
            ],
            [
                'flea_market_id' => 8,
                'start_date' => now()->addDays(550),
                'end_date' => now()->addDays(551),
            ],
            [
                'flea_market_id' => 9,
                'start_date' => now()->addDays(600),
                'end_date' => now()->addDays(603),
            ],
            [
                'flea_market_id' => 9,
                'start_date' => now()->addDays(650),
                'end_date' => now()->addDays(655),
            ],
            [
                'flea_market_id' => 10,
                'start_date' => now()->addDays(700),
                'end_date' => now()->addDays(705),
            ],
            [
                'flea_market_id' => 10,
                'start_date' => now()->addDays(750),
                'end_date' => now()->addDays(759),
            ],
            [
                'flea_market_id' => 11,
                'start_date' => now()->addDays(800),
                'end_date' => now()->addDays(805),
            ],
            [
                'flea_market_id' => 11,
                'start_date' => now()->addDays(850),
                'end_date' => now()->addDays(851),
            ],
            [
                'flea_market_id' => 12,
                'start_date' => now()->addDays(900),
                'end_date' => now()->addDays(905),
            ],
            [
                'flea_market_id' => 12,
                'start_date' => now()->addDays(950),
                'end_date' => now()->addDays(953),
            ],
            [
                'flea_market_id' => 13,
                'start_date' => now()->addDays(1000),
                'end_date' => now()->addDays(1002),
            ]
            ,
            [
                'flea_market_id' => 13,
                'start_date' => now()->addDays(200),
                'end_date' => now()->addDays(201),
            ],
            [
                'flea_market_id' => 14,
                'start_date' => now()->addDays(220),
                'end_date' => now()->addDays(223)  ,
            ],
            [
                'flea_market_id' => 14,
                'start_date' => now()->addDays(300),
                'end_date' => now()->addDays(3030),
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
