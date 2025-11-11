<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,  // PRIMERO: Crear permisos y roles
            RoleSeeder::class,        // Si existe, ejecutarlo después de PermissionSeeder
            UserSeeder::class,        // Crear usuarios después de roles
            ParametroSeeder::class,   // Crear parámetros
            // ClienteSeeder::class,   // Opcional: si quieres datos de prueba
        ]);
    }
}
