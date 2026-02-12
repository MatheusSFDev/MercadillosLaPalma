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
            ]
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