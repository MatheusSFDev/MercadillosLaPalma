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
                'img_url' => 'https://example.com/mercadillo-los-llanos.jpg',
                'municipality' => 'Los Llanos de Aridane',
            ],
            [
                'address' => 'Av. Marítima, Santa Cruz de La Palma',
                'img_url' => 'https://example.com/mercadillo-santa-cruz.jpg',
                'municipality' => 'Santa Cruz de La Palma',
            ],
            [
                'address' => 'Calle Manuel Taño, El Paso',
                'img_url' => 'https://example.com/mercadillo-el-paso.jpg',
                'municipality' => 'El Paso',
            ],
            [
                'address' => 'Plaza del Mercadillo, Puntagorda',
                'img_url' => 'https://example.com/mercadillo-puntagorda.jpg',
                'municipality' => 'Puntagorda',
            ],
            [
                'address' => 'Calle Charco, Fuencaliente',
                'img_url' => 'https://example.com/mercadillo-fuencaliente.jpg',
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
                    'img_url' => $market['img_url'],
                    'municipality_id' => $municipalityId,
                ]);
            }
        }
    }
}