<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Municipality;
use Illuminate\Support\Facades\DB;

class MunicipalitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Municipalities=[
            'Breña Alta',
            'Breña Baja',
            'Fuencaliente de la Palma',
            'Garafía',
            'Los Llanos de Aridane',
            'El Paso',
            'Puntagorda',
            'Puntallana',
            'San Andrés y Sauces',
            'Santa Cruz de la Palma',
            'Tazacorte',
            'Villa de Mazo',
            'Tijarafe',
            'Barlovento',
        ];
        foreach($Municipalities as $Municipality){
            DB::table('municipalities')->insert([
                'name' => $Municipality,
            ]);
        }

        
    }
}
