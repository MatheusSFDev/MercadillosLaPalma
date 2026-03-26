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
            [
                'name' => 'Juan',
                'surname' => 'Pascual',
                'address' => 'Avenida Siempre Viva 456',
                'phone_number' => '125678901',
                'email' => 'juan@example.com',
                'password' => 'password',
                'role' => 'seller'
            ],
            [
                'name' => 'Ana',
                'surname' => 'Martinez',
                'address' => ' Puerto de Tazacorte 321',
                'phone_number' => '1098765432',
                'email' => 'ana@example.com',
                'password' => 'password',
                'role' => 'customer'
            ],  
            [
                'name' => 'Paco',
                'surname' => 'García',
                'address' => 'Calle del Mar 456',
                'phone_number' => '987654321',
                'email' => 'paco@example.com',
                'password' => 'password',
                 'role' => 'customer'
            ],
            [
                'name' => 'María',
                'surname' => 'Pérez',
                'address' => 'Calle del Sol 789',
                'phone_number' => '104595678',
                'email' => 'maria@example.com',
                'password' => 'password',
                'role' => 'seller'
            ],
            [
                'name' => 'Matheus',
                'surname' => 'Du Brasil',
                'address' => 'Calle del Viento 321',
                'phone_number' => '109876543',
                'email' => 'matheus@example.com',
                'password' => 'password',
                'role' => 'root'
            ],
            [
                'name' => 'Gabriel',
                'surname' => 'López',
                'address' => 'Avenida del Mar 654',
                'phone_number' => '0945678901',
                'email' => 'gabriel@example.com',
                'password' => 'password',
                'role' => 'admin'
            ],
            [
                'name' => 'Abel',
                'surname' => 'Klein',
                'address' => 'Muelle de Santa Cruz 987',
                'phone_number' => '485678901',
                'email' => 'abel@example.com',
                'password' => 'password',
                'role' => 'customer'
            ],
            [
                'name' => 'William',
                'surname' => 'Quijada',
                'address' => 'Ñuñoa 123',
                'phone_number' => '1945678901',
                'email' => 'william@example.com',
                'password' => 'password',
                'role' => 'seller'
            ],
            [
                'name' => 'Bruno',
                'surname' => 'Hernandez',
                'address' => 'Don Pedro 456',
                'phone_number' => '6845678901',
                'email' => 'bruno@example.com',
                'password' => 'password',
                'role' => 'customer'
            ],
            [
                'name' => 'Isabel',
                'surname' => 'Sanchez',
                'address' => 'Avenida Siempre Viva 456',
                'phone_number' => '1234578901',
                'email' => 'isabel@example.com',
                'password' => 'password',
                'role' => 'customer'
            ],
            [
                'name' => 'William',
                'surname' => 'Afton',
                'address' => 'The Springtrap Street 789',
                'phone_number' => '9045678901',
                'email' => 'william@example.com',
                'password' => 'password',
                'role' => 'customer'
            ],
            [
                'name' => 'Kris',
                'surname' => 'Dreemurr',
                'address' => 'Underground 123',
                'phone_number' => '0945678901',
                'email' => 'kris@example.com',
                'password' => 'password',
                'role' => 'customer'
            ],
            [
                'name' => 'Matthias',
                'surname' => 'Schneider',
                'address' => 'Calle del Mercado 456',
                'phone_number' => '567845678901',
                'email' => 'matthias@example.com',
                'password' => 'password',
                'role' => 'customer'
            ],
            [
                'name' => 'Lois',
                'surname' => 'Lane',
                'address' => 'Metropolis 789',
                'phone_number' => '956789012',
                'email' => 'lois@example.com',
                'password' => 'password',
                'role' => 'customer'
            ],
            [
                'name' => 'Bruce',
                'surname' => 'Wayne',
                'address' => 'Gotham City 123',
                'phone_number' => '1234567890',
                'email' => 'notbatman@example.com',
                'password' => 'password',
                'role' => 'admin'
            ],
            [
                'name' => 'Klark',
                'surname' => 'Kent',
                'address' => 'Metropolis 123',
                'phone_number' => '1234567890',
                'email' => 'notsuperman@example.com',
                'password' => 'password',
                'role' => 'customer'
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