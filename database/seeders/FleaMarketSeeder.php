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
                'img_url' => 'img/fleaMarkets/Los_Llanos.jpg',
            ],
            [
                'address' => 'Av. Marítima, Santa Cruz de La Palma',
                'municipality' => 'Santa Cruz de La Palma',
                'img_url' => 'img/fleaMarkets/Santa_Cruz.jpg',
            ],
            [
                'address' => 'Calle Manuel Taño, El Paso',
                'municipality' => 'El Paso',
                'img_url' => 'img/fleaMarkets/El_Paso.jpg',
            ],
            [
                'address' => 'Plaza del Mercadillo, Puntagorda',
                'municipality' => 'Puntagorda',
                'img_url' => 'img/fleaMarkets/Puntagorda.jpg',
            ],
            [
                'address' => 'Calle Charco, Fuencaliente',
                'municipality' => 'Fuencaliente de La Palma',
                'img_url' => 'img/fleaMarkets/Fuencaliente.jpg',
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
                    'img_url' => $market['img_url'] ?? 'img/imgNotAvailable.png',
                ]);
            }
        }
    }
}