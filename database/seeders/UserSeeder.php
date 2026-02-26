<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [ 
            [
                'name' => 'Generic',
                'surname' => 'Lopez',
                'address' => 'Avenida Siempre Viva 456',
                'phone_number' => '987654321',
                'email' => 'generic@example.com',
                'password' => 'password',
                'role' => 'customer'
            ], 
            [
                'name' => 'Customer',
                'surname' => 'Lopez',
                'address' => 'Avenida Siempre Viva 456',
                'phone_number' => '987654321',
                'email' => 'customer@example.com',
                'password' => 'password',
                'role' => 'customer'
            ],
            [
                'name' => 'Seller',
                'surname' => 'Perez',
                'address' => 'Calle Real 789',
                'phone_number' => '555555555',
                'email' => 'seller@example.com',
                'password' => 'password',
                'role' => 'seller'
            ],
            [
                'name' => 'Admin',
                'surname' => 'Gimenez',
                'address' => 'Calle Falsa 123',
                'phone_number' => '123456789',
                'email' => 'admin@example.com',
                'password' => 'password',
                'role' => 'admin'
            ],
            [
                'name' => 'Root',
                'surname' => 'Perez',
                'address' => 'Calle Real 789',
                'phone_number' => '555555555',
                'email' => 'root@example.com',
                'password' => 'password',
                'role' => 'root'
            ], 
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'surname' => $data['surname'],
                    'address' => $data['address'],
                    'phone_number' => $data['phone_number'],
                    'password' => Hash::make($data['password']),
                ]
            );

            $user->assignRole($data['role']); // ahora sí funciona
        }
    }
}