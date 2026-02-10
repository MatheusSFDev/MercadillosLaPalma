<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StallsSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Stalls = [
            [
                'User_id' => '1',
                'flea_market_id' => '1',
                'home_delivery' => '0',
                'information' => 'Vendo ropa de segunda mano en buen estado',
                'active' => '1',
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days'))
            ],
            [
                'User_id' => '2',
                'flea_market_id' => '1',
                'home_delivery' => '1',
                'information' => 'Vendo muebles antiguos restaurados',
                'active' => '1',
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days'))
            ],
            [
                'User_id' => '2',
                'flea_market_id' => '2',
                'home_delivery' => '0',
                'information' => 'Vendo juguetes y juegos de mesa usados',
                'active' => '1',
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days'))
            ],
             [
                'User_id' => '1',
                'flea_market_id' => '2',
                'home_delivery' => '1',
                'information' => 'Vendo libros de segunda mano en buen estado',
                'active' => '1',
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days'))
            ]
        ];
        foreach ($Stalls as $stall) {
            DB::table('stalls')->insert([
                'User_id' => $stall['User_id'],
                'flea_market_id' => $stall['flea_market_id'],
                'home_delivery' => $stall['home_delivery'],
                'information' => $stall['information'],
                'active' => $stall['active'],
                'reset_date' => $stall['reset_date']
            ]);
        }
    }
}
