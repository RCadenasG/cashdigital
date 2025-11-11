<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@cashdigital.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'telefono' => '999999999',
            ]
        );
        $admin->assignRole('admin');

        // Usuario normal
        $user = User::firstOrCreate(
            ['email' => 'user@cashdigital.com'],
            [
                'name' => 'Usuario Normal',
                'password' => Hash::make('password'),
                'telefono' => '888888888',
            ]
        );
        $user->assignRole('user');

        // Cajero
        $cajero = User::firstOrCreate(
            ['email' => 'cajero@cashdigital.com'],
            [
                'name' => 'Cajero',
                'password' => Hash::make('password'),
                'telefono' => '777777777',
            ]
        );
        $cajero->assignRole('cajero');
    }
}
