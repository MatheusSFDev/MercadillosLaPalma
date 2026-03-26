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
                'user_id' => 3,
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
                'user_id' => 3,
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
                'user_id' => 4,
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
                'user_id' => 4,
                'flea_market_id' => 2,
                'home_delivery' => 1,
                'information' => 'Vendo libros de segunda mano en buen estado',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Libros Usados',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 6,
                'flea_market_id' => 1,
                'home_delivery' => 0,
                'information' => 'muebles de segunda mano en buen estado',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Muebles y más',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 13,
                'flea_market_id' => 1,
                'home_delivery' => 1,
                'information' => 'Vendo juegos retro',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Juegos Retro',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 9,
                'flea_market_id' => 1,
                'home_delivery' => 0,
                'information' => 'Floristeria con plantas de interior y exterior',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Floristeria',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 4,
                'flea_market_id' => 1,
                'home_delivery' => 1,
                'information' => 'ropa organica y sostenible',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Ropa Orgánica',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 6,
                'flea_market_id' => 1,
                'home_delivery' => 0,
                'information' => 'fruta y verdura de temporada',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Frutas y Verduras',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 9,
                'flea_market_id' => 1,
                'home_delivery' => 1,
                'information' => 'artículos de decoración para el hogar',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Decoración Hogar',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 13,
                'flea_market_id' => 1,
                'home_delivery' => 0,
                'information' => 'artículos de electrónica de segunda mano',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Electrónica Usada',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 9,
                'flea_market_id' => 1,
                'home_delivery' => 1,
                'information' => 'artículos de cocina y',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Cocina con manolo',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        DB::table('stalls')->insert($stalls);
    }
}