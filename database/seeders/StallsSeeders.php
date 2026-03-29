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
                'information' => 'Carnes frescas de cerdo negro palmero',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Carnes Don Pedro',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 6,
                'flea_market_id' => 1,
                'home_delivery' => 1,
                'information' => 'Frutas y verduras ecológicas del valle',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Frutas del Valle',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 9,
                'flea_market_id' => 1,
                'home_delivery' => 0,
                'information' => 'Flores tropicales y plantas ornamentales',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Floristería La Palma',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 13,
                'flea_market_id' => 1,
                'home_delivery' => 0,
                'information' => 'Artesanía tradicional palmera',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Artesanía Palmera',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 3,
                'flea_market_id' => 2,
                'home_delivery' => 0,
                'information' => 'Pescado y marisco fresco del día',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Pescadería El Puerto',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 6,
                'flea_market_id' => 2,
                'home_delivery' => 1,
                'information' => 'Quesos artesanales palmeros con D.O.P.',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Quesos La Palma',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 9,
                'flea_market_id' => 2,
                'home_delivery' => 0,
                'information' => 'Pan artesanal y bollería tradicional',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Panadería La Tradición',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 13,
                'flea_market_id' => 3,
                'home_delivery' => 1,
                'information' => 'Vinos, licores y productos de bodega palmera',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Bodega El Volcán',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 9,
                'flea_market_id' => 3,
                'home_delivery' => 0,
                'information' => 'Dulces y repostería tradicional canaria',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Dulces Canarios',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 6,
                'flea_market_id' => 4,
                'home_delivery' => 0,
                'information' => 'Almendras y frutos secos de Puntagorda',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Almendras de Puntagorda',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 3,
                'flea_market_id' => 5,
                'home_delivery' => 0,
                'information' => 'Vinos volcánicos y sal marina artesanal',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Sal y Vino',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 6,
                'flea_market_id' => 6,
                'home_delivery' => 1,
                'information' => 'Verduras y hortalizas orgánicas',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Verduras Orgánicas',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 13,
                'flea_market_id' => 7,
                'home_delivery' => 0,
                'information' => 'Puros artesanales y productos de artesanía',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Puros y Artesanía',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 6,
                'flea_market_id' => 8,
                'home_delivery' => 1,
                'information' => 'Plátanos y frutas tropicales del norte de La Palma',
                'active' => 1,
                'reset_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'register_date' => date('Y-m-d H:i:s'),
                'name' => 'Plátanos del Norte',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        DB::table('stalls')->insert($stalls);
    }
}