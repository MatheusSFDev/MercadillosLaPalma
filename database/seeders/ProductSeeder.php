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
            ['name' => 'Carne de cerdo negro', 'unit'=>'Kg', 'description' => 'Carne de cerdo negro palmero criado en semilibertad', 'user_id'=>3, 'category_id'=>1],
            ['name' => 'Costillas adobadas', 'unit'=>'Kg', 'description' => 'Costillas de cerdo adobadas con especias locales', 'user_id'=>3, 'category_id'=>1],
            ['name' => 'Chistorra artesanal', 'unit'=>'Kg', 'description' => 'Chistorra elaborada de forma artesanal', 'user_id'=>3, 'category_id'=>1],
            ['name' => 'Pescado fresco del día', 'unit'=>'Kg', 'description' => 'Pescado fresco capturado en aguas de La Palma', 'user_id'=>3, 'category_id'=>2],
            ['name' => 'Pulpo', 'unit'=>'Kg', 'description' => 'Pulpo fresco de la costa palmera', 'user_id'=>3, 'category_id'=>2],
            ['name' => 'Lapas', 'unit'=>'Kg', 'description' => 'Lapas frescas recogidas en la costa', 'user_id'=>3, 'category_id'=>2],
            ['name' => 'Plátanos de Canarias', 'unit'=>'Kg', 'description' => 'Plátanos cultivados en el valle de Aridane', 'user_id'=>6, 'category_id'=>3],
            ['name' => 'Aguacates de La Palma', 'unit'=>'Kg', 'description' => 'Aguacates ecológicos de cultivo local', 'user_id'=>6, 'category_id'=>3],
            ['name' => 'Papas negras', 'unit'=>'Kg', 'description' => 'Papas negras canarias de producción local', 'user_id'=>6, 'category_id'=>3],
            ['name' => 'Tomates', 'unit'=>'Kg', 'description' => 'Tomates de huerta palmera', 'user_id'=>6, 'category_id'=>3],
            ['name' => 'Batatas', 'unit'=>'Kg', 'description' => 'Batatas dulces de cultivo tradicional', 'user_id'=>6, 'category_id'=>3],
            ['name' => 'Almendras', 'unit'=>'Kg', 'description' => 'Almendras de Puntagorda', 'user_id'=>6, 'category_id'=>3],
            ['name' => 'Cerámica artesanal', 'unit'=>'unidad/es', 'description' => 'Piezas de cerámica hechas a mano por artesanos locales', 'user_id'=>13, 'category_id'=>4],
            ['name' => 'Puros palmeros', 'unit'=>'unidad/es', 'description' => 'Puros elaborados artesanalmente en La Palma', 'user_id'=>13, 'category_id'=>4],
            ['name' => 'Cestería de mimbre', 'unit'=>'unidad/es', 'description' => 'Cestas y objetos tejidos en mimbre', 'user_id'=>13, 'category_id'=>4],
            ['name' => 'Queso Palmero curado', 'unit'=>'Kg', 'description' => 'Queso Palmero D.O.P. curado de leche de cabra', 'user_id'=>6, 'category_id'=>5],
            ['name' => 'Queso tierno', 'unit'=>'Kg', 'description' => 'Queso tierno de cabra palmera', 'user_id'=>6, 'category_id'=>5],
            ['name' => 'Queso ahumado', 'unit'=>'Kg', 'description' => 'Queso ahumado con cáscara de almendra y pino canario', 'user_id'=>6, 'category_id'=>5],
            ['name' => 'Strelitzia', 'unit'=>'unidad/es', 'description' => 'Ave del Paraíso, flor emblemática de La Palma', 'user_id'=>9, 'category_id'=>6],
            ['name' => 'Cactus y suculentas', 'unit'=>'unidad/es', 'description' => 'Plantas decorativas adaptadas al clima canario', 'user_id'=>9, 'category_id'=>6],
            ['name' => 'Ramos de flores', 'unit'=>'unidad/es', 'description' => 'Ramos elaborados con flores tropicales', 'user_id'=>9, 'category_id'=>6],
            ['name' => 'Pan de papa', 'unit'=>'unidad/es', 'description' => 'Pan tradicional palmero hecho con papa', 'user_id'=>9, 'category_id'=>7],
            ['name' => 'Rosquetes', 'unit'=>'unidad/es', 'description' => 'Rosquetes glaseados típicos de La Palma', 'user_id'=>9, 'category_id'=>7],
            ['name' => 'Truchas de batata', 'unit'=>'unidad/es', 'description' => 'Empanadillas dulces rellenas de batata', 'user_id'=>9, 'category_id'=>7],
            ['name' => 'Aloe vera natural', 'unit'=>'unidad/es', 'description' => 'Gel de aloe vera puro cultivado en La Palma', 'user_id'=>13, 'category_id'=>8],
            ['name' => 'Jabón artesanal', 'unit'=>'unidad/es', 'description' => 'Jabones naturales con ingredientes locales', 'user_id'=>13, 'category_id'=>8],
            ['name' => 'Vino de tea', 'unit'=>'L', 'description' => 'Vino tradicional palmero envejecido en madera de tea', 'user_id'=>3, 'category_id'=>8],
            ['name' => 'Ron miel', 'unit'=>'L', 'description' => 'Ron miel artesanal canario', 'user_id'=>13, 'category_id'=>8],
            ['name' => 'Miel de palma', 'unit'=>'L', 'description' => 'Miel de palma (guarapo) de La Gomera y La Palma', 'user_id'=>13, 'category_id'=>8],
            ['name' => 'Bienmesabe', 'unit'=>'Kg', 'description' => 'Dulce tradicional de almendras y huevo', 'user_id'=>9, 'category_id'=>8],
            ['name' => 'Rapadura', 'unit'=>'unidad/es', 'description' => 'Dulce de miel de palma y gofio', 'user_id'=>9, 'category_id'=>8],
            ['name' => 'Almendrados', 'unit'=>'Kg', 'description' => 'Pastas de almendra típicas palmeras', 'user_id'=>13, 'category_id'=>8],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'unit' => $product['unit'],
                'description' => $product['description'],
                'user_id' => $product['user_id'],
                'category_id' => $product['category_id']
            ]);
        }
    }
}
