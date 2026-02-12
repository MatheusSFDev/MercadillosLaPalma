<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FleaMarketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fleaMarkets = [
            [
                'address' => 'Av. Carlos Francisco Lorenzo Navarro, Los Llanos',
                'municipality' => 'Los Llanos de Aridane',
            ],
            [
                'address' => 'Av. Marítima, Santa Cruz de La Palma',
                'municipality' => 'Santa Cruz de La Palma',
            ],
            [
                'address' => 'Calle Manuel Taño, El Paso',
                'municipality' => 'El Paso',
            ],
            [
                'address' => 'Plaza del Mercadillo, Puntagorda',
                'municipality' => 'Puntagorda',
            ],
            [
                'address' => 'Calle Charco, Fuencaliente',
                'municipality' => 'Fuencaliente de La Palma',
            ],
        ];

        foreach ($fleaMarkets as $market) {
            $municipalityId = DB::table('municipalities')
                ->where('name', $market['municipality'])
                ->value('id');

            if ($municipalityId) {
                DB::table('flea_markets')->insert([
                    'address' => $market['address'],
                    'municipality_id' => $municipalityId,
                ]);
            }
        }
    }
}