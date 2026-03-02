<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SessionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Session=[
            [
                'id'=>'as213rfdsf21342dsdf',
                'user_id'=>'1',
                'ip_address'=>'12.34.56.78',
                'user_agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'payload'=>'eyJpdiI6IjVhZlJmVjN1c3l5c2lXbG9aZ0t3PT0iLCJ2YWx1ZSI6IjVvTjJkK3l5c2lXbG9aZ0t3PT0iLCJtYWMiOiI4YjE4ODg5ODQyYjA4ZDE5YjA4ZDE5YjA',
                'last_activity'=>'1620000000',
            ], 
            [
                'id'=>'bs324rfdsf21342dsdf',
                'user_id'=>'2',
                'ip_address'=>'45.67.89.10',
                'user_agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'payload'=>'eyJpdiI6IjVhZlJmVjN1c3l5c2lXbG9aZ0t3PT0iLCJ2YWx1ZSI6IjVvTjJkK3l5c2lXbG9aZ0t3PT0iLCJtYWMiOiI4YjE4ODg5ODQyYjA4ZDE5YjA4ZDE5YjA',
                'last_activity'=>'1620000000',
            ],
            [
                'id'=>'cs435rfdsf21342dsdf', 
                'user_id'=>'3',
                'ip_address'=>'13.12.234.54',
                'user_agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'payload'=>'eyJpdiI6IjVhZlJmVjN1c3l5c2lXbG9aZ0t3PT0iLCJ2YWx1ZSI6IjVvTjJkK3l5c2lXbG9aZ0t3PT0iLCJtYWMiOiI4YjE4ODg5ODQyYjA4ZDE5YjA4ZDE5YjA',
                'last_activity'=>'1620000000',
            ],
            [
                'id'=>'ds546rfdsf21342dsdf',
                'user_id'=>'4',
                'ip_address'=>'98.76.54.32',
                'user_agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'payload'=>'eyJpdiI6IjVhZlJmVjN1c3l5c2lXbG9aZ0t3PT0iLCJ2YWx1ZSI6IjVvTjJkK3l5c2lXbG9aZ0t3PT0iLCJtYWMiOiI4YjE4ODg5ODQyYjA4ZDE5YjA4ZDE5YjA',
                'last_activity'=>'1620000000',
            ]

        ];
        foreach ($Session as $Session) {
            DB::table('sessions')->insert(
                [
                    'id' => $Session['id'],
                    'user_id' => $Session['user_id'],    
                    'ip_address' => $Session['ip_address'],
                    'user_agent' => $Session['user_agent'],
                    'payload' => $Session['payload'],
                    'last_activity' => $Session['last_activity'],
                ]
            );
        }
    }
}
