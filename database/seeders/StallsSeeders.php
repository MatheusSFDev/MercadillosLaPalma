<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StallsSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stalls = [
            [
                'user_id' => 1,
                'flea_market_id' => 1,
                'home_delivery' => 0,
                'information' => 'Vendo ropa de segunda mano en buen estado',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Ropa Vintage',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 2,
                'flea_market_id' => 1,
                'home_delivery' => 1,
                'information' => 'Vendo muebles antiguos restaurados',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Muebles Clásicos',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 2,
                'flea_market_id' => 2,
                'home_delivery' => 0,
                'information' => 'Vendo juguetes y juegos de mesa usados',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Juguetes Retro',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 1,
                'flea_market_id' => 2,
                'home_delivery' => 1,
                'information' => 'Vendo libros de segunda mano en buen estado',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Libros Usados',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        DB::table('stalls')->insert($stalls);
    }
}