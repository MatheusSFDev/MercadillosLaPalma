<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [
            [
                'name' => 'Root',
                'surname' => 'System',
                'address' => 'Sistema',
                'phone_number' => '000000000',
                'email' => 'root@example.com',
                'password' => 'password',
                'role' => 'root'
            ],
            [
                'name' => 'Paco',
                'surname' => 'Gimenez',
                'address' => 'Calle Falsa 123',
                'phone_number' => '123456789',
                'email' => 'paco@example.com',
                'password' => 'password',
                'role' => 'customer'
            ],
            [
                'name' => 'Maria',
                'surname' => 'Lopez',
                'address' => 'Avenida Siempre Viva 456',
                'phone_number' => '987654321',
                'email' => 'maria@example.com',
                'password' => 'password',
                'role' => 'customer'
            ],
            [
                'name' => 'Juan',
                'surname' => 'Perez',
                'address' => 'Calle Real 789',
                'phone_number' => '555555555',
                'email' => 'juan@example.com',
                'password' => 'password',
                'role' => 'customer'
            ]
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

            $user->assignRole($data['role']);
        }
    }
}