<?php


namespace Database\Seeders;


use App\Enums\Days;
use App\Models\Schedule;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;


class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules=[[
            'flea_market_id'=>'1',
            'day_of_week'=>Days::Lunes,
            'opening_time'=> now(),
            'closing_time'=> now()->addHours(8)
        ],
        [
            'flea_market_id'=>'1',
            'day_of_week'=>Days::Martes,
            'opening_time'=> now(),
            'closing_time'=> now()->addHours(10)
        ],
        [
            'flea_market_id'=>'1',
            'day_of_week'=>Days::Miercoles,
            'opening_time'=> now(),
            'closing_time'=> now()->addHours(16)
        ],
        [
            'flea_market_id'=>'1',
            'day_of_week'=>Days::Jueves,
            'opening_time'=> now(),
            'closing_time'=> now()->addHours(4)  
        ],
        [
            'flea_market_id'=>'1',
            'day_of_week'=>Days::Viernes,
            'opening_time'=> now(),
            'closing_time'=> now()->addHours(5)  
        ]];
        foreach ($schedules as $schedule) {
            DB::table('Schedules')->insert(
                [
                    'flea_market_id' => $schedule['flea_market_id'],
                    'day_of_week' => $schedule['day_of_week'],
                    'opening_time'=> $schedule['opening_time'],
                    'closing_time'=> $schedule['closing_time']
                ]
            );
        }
       
    }
}
