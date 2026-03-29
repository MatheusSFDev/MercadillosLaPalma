<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhotosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $photos = [
            [
                'product_name' => 'Carne de cerdo negro',
                'url' => 'img/products/carne_cerdo_negro.jpg',
                'description' => 'Carne fresca de cerdo negro palmero',
            ],
            [
                'product_name' => 'Costillas adobadas',
                'url' => 'img/products/costillas_adobadas.jpg',
                'description' => 'Costillas adobadas listas para la parrilla',
            ],
            [
                'product_name' => 'Pescado fresco del día',
                'url' => 'img/products/pescado_fresco.jpg',
                'description' => 'Pescado fresco recién capturado',
            ],
            [
                'product_name' => 'Plátanos de Canarias',
                'url' => 'img/products/platanos.jpg',
                'description' => 'Plátanos de Canarias de La Palma',
            ],
            [
                'product_name' => 'Aguacates de La Palma',
                'url' => 'img/products/aguacates.jpg',
                'description' => 'Aguacates ecológicos de cultivo local',
            ],
            [
                'product_name' => 'Queso Palmero curado',
                'url' => 'img/products/queso_palmero.jpg',
                'description' => 'Queso Palmero D.O.P. curado',
            ],
            [
                'product_name' => 'Queso ahumado',
                'url' => 'img/products/queso_ahumado.jpg',
                'description' => 'Queso ahumado artesanal',
            ],
            [
                'product_name' => 'Strelitzia',
                'url' => 'img/products/strelitzia.jpg',
                'description' => 'Ave del Paraíso en flor',
            ],
            [
                'product_name' => 'Cerámica artesanal',
                'url' => 'img/products/ceramica.jpg',
                'description' => 'Pieza de cerámica artesanal palmera',
            ],
            [
                'product_name' => 'Puros palmeros',
                'url' => 'img/products/puros_palmeros.jpg',
                'description' => 'Puros artesanales de La Palma',
            ],
            [
                'product_name' => 'Pan de papa',
                'url' => 'img/products/pan_de_papa.jpg',
                'description' => 'Pan tradicional palmero',
            ],
            [
                'product_name' => 'Rosquetes',
                'url' => 'img/products/rosquetes.jpg',
                'description' => 'Rosquetes glaseados artesanales',
            ],
            [
                'product_name' => 'Vino de tea',
                'url' => 'img/products/vino_de_tea.jpg',
                'description' => 'Vino envejecido en madera de tea',
            ],
            [
                'product_name' => 'Miel de palma',
                'url' => 'img/products/miel_de_palma.jpg',
                'description' => 'Miel de palma canaria',
            ],
            [
                'product_name' => 'Bienmesabe',
                'url' => 'img/products/bienmesabe.jpg',
                'description' => 'Dulce tradicional de almendras',
            ],
            [
                'product_name' => 'Rapadura',
                'url' => 'img/products/rapadura.jpg',
                'description' => 'Rapadura de miel de palma y gofio',
            ],
            [
                'product_name' => 'Almendrados',
                'url' => 'img/products/almendrados.jpg',
                'description' => 'Pastas de almendra típicas',
            ],
            [
                'product_name' => 'Aloe vera natural',
                'url' => 'img/products/aloe_vera.jpg',
                'description' => 'Gel de aloe vera puro',
            ],
        ];

        foreach ($photos as $photo) {
            $productId = DB::table('products')
                ->where('name', $photo['product_name'])
                ->value('id');

            if ($productId) {
                DB::table('photos')->insert([
                    'url' => $photo['url'],
                    'description' => $photo['description'],
                    'product_id' => $productId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}