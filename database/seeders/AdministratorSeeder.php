<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assignments = [
            [
                'user_email' => 'paco@example.com',
                'flea_market_address' => 'Av. Carlos Francisco Lorenzo Navarro, Los Llanos',
            ],
            [
                'user_email' => 'admin@example.com',
                'flea_market_address' => 'Av. Carlos Francisco Lorenzo Navarro, Los Llanos',
            ],
            [
                'user_email' => 'admin@example.com',
                'flea_market_address' => 'Av. Marítima, Santa Cruz de La Palma',
            ],
            [
                'user_email' => 'admin@example.com',
                'flea_market_address' => 'Calle Manuel Taño, El Paso',
            ],
            [
                'user_email' => 'notbatman@example.com',
                'flea_market_address' => 'Plaza del Mercadillo, Puntagorda',
            ],
            [
                'user_email' => 'gabriel@example.com',
                'flea_market_address' => 'Calle Charco, Fuencaliente',
            ],
            [
                'user_email' => 'admin@example.com',
                'flea_market_address' => 'Parque de Los Álamos, Breña Alta',
            ],
            [
                'user_email' => 'notbatman@example.com',
                'flea_market_address' => 'Paseo del Charco del Lino, Breña Baja',
            ],
            [
                'user_email' => 'notbatman@example.com',
                'flea_market_address' => 'Plaza de Montserrat, San Andrés y Sauces',
            ],
            [
                'user_email' => 'admin@example.com',
                'flea_market_address' => 'Calle Doctor Morera Bravo, Villa de Mazo',
            ],
            [
                'user_email' => 'paco@example.com',
                'flea_market_address' => 'Centro de Promoción Agraria de San Antonio del Monte, Garafía',
            ],
            [
                'user_email' => 'notbatman@example.com',
                'flea_market_address' => 'El Jesús, Tijarafe',
            ],
            [
                'user_email' => 'admin@example.com',
                'flea_market_address' => 'Muelle Deportivo, Tazacorte',
            ],
            [
                'user_email' => 'gabriel@example.com',
                'flea_market_address' => 'Calle La Camacha, Puntallana',
            ],
            [
                'user_email' => 'gabriel@example.com',
                'flea_market_address' => 'Plaza del Rosario, s/n, 38726, Barlovento',
            ],
            
        ];

        foreach ($assignments as $assignment) {
            $userId = DB::table('users')
                ->where('email', $assignment['user_email'])
                ->value('id');

            $fleaMarketId = DB::table('flea_markets')
                ->where('address', $assignment['flea_market_address'])
                ->value('id');

            if ($userId && $fleaMarketId) {
                DB::table('administrators')->updateOrInsert(
                    [
                        'user_id' => $userId,
                        'flea_market_id' => $fleaMarketId,
                    ],
                    []
                );
            }
        }
    }
}