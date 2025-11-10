<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario administrador
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'telefono' => '999999999',
                'estado' => 1,
            ]
        );

        $adminUser->assignRole('admin');

        // Crear usuario estándar
        $user = User::firstOrCreate(
            ['email' => 'usuario@example.com'],
            [
                'name' => 'Usuario Regular',
                'password' => Hash::make('password'),
                'telefono' => '988888888',
                'estado' => 1,
            ]
        );

        $user->assignRole('usuario');
    }
}
