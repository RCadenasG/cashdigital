<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Resetear cachés de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        $permissions = [
            // Parámetros
            'ver_parametros',
            'crear_parametros',
            'editar_parametros',
            'eliminar_parametros',

            // Usuarios
            'ver_usuarios',
            'crear_usuarios',
            'editar_usuarios',
            'eliminar_usuarios',

            // Roles
            'ver_roles',
            'crear_roles',
            'editar_roles',
            'eliminar_roles',

            // Clientes
            'ver_clientes',
            'crear_clientes',
            'editar_clientes',
            'eliminar_clientes',

            // Operaciones
            'ver_operaciones',
            'crear_operaciones',
            'editar_operaciones',
            'eliminar_operaciones',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Crear roles y asignar permisos

        // Rol Admin - todos los permisos
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(Permission::all());

        // Rol Usuario - permisos limitados
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $userRole->givePermissionTo([
            'ver_clientes',
            'crear_clientes',
            'editar_clientes',
            'ver_operaciones',
            'crear_operaciones',
        ]);

        // Rol Cajero - permisos de operaciones
        $cajeroRole = Role::firstOrCreate(['name' => 'cajero', 'guard_name' => 'web']);
        $cajeroRole->givePermissionTo([
            'ver_clientes',
            'ver_operaciones',
            'crear_operaciones',
        ]);
    }
}
