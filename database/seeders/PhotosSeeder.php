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
                'product_name' => 'Carne de cerdo',
                'url' => 'https://example.com/products/carne-cerdo-1.jpg',
                'description' => 'Carne de cerdo fresca de producción local',
            ],
            [
                'product_name' => 'Carne de cerdo',
                'url' => 'https://example.com/products/carne-cerdo-2.jpg',
                'description' => 'Corte tradicional de carne de cerdo',
            ],
            [
                'product_name' => 'Pescado fresco',
                'url' => 'https://example.com/products/pescado-fresco.jpg',
                'description' => 'Pescado fresco del día',
            ],
            [
                'product_name' => 'Frutas y verduras',
                'url' => 'https://example.com/products/frutas-verduras.jpg',
                'description' => 'Frutas y verduras cultivadas en La Palma',
            ],
            [
                'product_name' => 'Artesanía local',
                'url' => 'https://example.com/products/artesania-local.jpg',
                'description' => 'Piezas de artesanía hechas a mano',
            ],
            [
                'product_name' => 'Productos varios',
                'url' => 'https://example.com/products/productos-varios.jpg',
                'description' => null,
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