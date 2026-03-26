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
            [
                'address' => 'Parque de Los Álamos, Breña Alta',
                'municipality' => 'Breña Alta',
                'img_url' => 'img/fleaMarkets/Breña_Alta.jpg',
            ],
            [
                'address' => 'Paseo del Charco del Lino, Breña Baja',
                'municipality' => 'Breña Baja',
                'img_url' => 'img/fleaMarkets/Breña_Baja.jpg',
            ],
            [
                'address' => 'Plaza de Montserrat, San Andrés y Sauces',
                'municipality' => 'San Andrés y Sauces',
                'img_url' => 'img/fleaMarkets/San_Andres_y_Sauces.jpg',
            ],
            [
                'address' => 'Calle Doctor Morera Bravo, Villa de Mazo',
                'municipality' => 'Villa de Mazo',
                'img_url' => 'img/fleaMarkets/Villa_de_Mazo.jpg',
            ],
            [
                'address' => 'Muelle deportivo, Tazacorte',
                'municipality' => 'Tazacorte',
                'img_url' => 'img/fleaMarkets/Tazacorte.jpg',
            ],
            [
                'address' => 'Calle La Camacha, Puntallana',
                'municipality' => 'Puntallana',
                'img_url' => 'img/fleaMarkets/Puntallana.jpg',
            ],
            [
                'address' => 'El Jesús, Tijarafe',
                'municipality' => 'Tijarafe',
                'img_url' => 'img/fleaMarkets/Tijarafe.jpg',
            ],
            [
                'address' => 'Centro de Promoción Agraria de San Antonio del Monte, Garafía',
                'municipality' => 'Garafía',
                'img_url' => 'img/fleaMarkets/Garafia.jpg',
            ],
            [
                'address' => 'Plaza del Rosario, s/n, 38726, Barlovento',
                'municipality' => 'Barlovento',
                'img_url' => 'img/fleaMarkets/Barlovento.jpg',
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