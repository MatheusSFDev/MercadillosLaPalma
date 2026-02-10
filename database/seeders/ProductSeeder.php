<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Carne de cerdo',
                'photos' => 'carne_de_cerdo.jpg',
                'unit'=>'kg',
                'user_id'=>1,
                'category_id'=>1
            ],
            [
                'name' => 'Pescado fresco',
                'photos' => 'pescado_fresco.jpg',
                'unit'=>'kg',
                'user_id'=>2,
                'category_id'=>2
            ],
            [
                'name' => 'Frutas y verduras',
                'photos' => 'frutas_verduras.jpg',
                'unit'=>'kg',
                'user_id'=>3,
                'category_id'=>3
            ],
            [
                'name' => 'Artesanía local',
                'photos' => 'artesania_local.jpg',
                'unit'=>'kg',
                'user_id'=>1,
                'category_id'=>4
            ],
            [
                'name' => 'Productos varios',
                'photos' => 'productos_varios.jpg',
                'unit'=>'kg ',
                'user_id'=>2,
                'category_id'=>5
            ]
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'photos' => $product['photos'],
                'unit' => $product['unit'],
                'user_id' => $product['user_id'],
                'category_id' => $product['category_id']
            ]);
        }
}
}
