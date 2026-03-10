<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fleaMarkets = DB::table('flea_markets')->get();

        foreach ($fleaMarkets as $market) {
            $schedules = [
                ['day_of_week' => 'Lunes', 'opening_time' => null, 'closing_time' => null],
                ['day_of_week' => 'Martes', 'opening_time' => null, 'closing_time' => null],
                ['day_of_week' => 'Miércoles', 'opening_time' => null, 'closing_time' => null],
                ['day_of_week' => 'Jueves', 'opening_time' => null, 'closing_time' => null],
                ['day_of_week' => 'Viernes', 'opening_time' => null, 'closing_time' => null],
                ['day_of_week' => 'Sábado', 'opening_time' => '09:00', 'closing_time' => '14:00'],
                ['day_of_week' => 'Domingo', 'opening_time' => '09:00', 'closing_time' => '14:00'],
            ];

            foreach ($schedules as $schedule) {
                DB::table('schedules')->insert([
                    'flea_market_id' => $market->id,
                    'day_of_week' => $schedule['day_of_week'],
                    'opening_time' => $schedule['opening_time'],
                    'closing_time' => $schedule['closing_time'],
                ]);
            }
        }
    }
}