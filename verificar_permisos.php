<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

echo "=== VERIFICACIÓN DE PERMISOS Y ROLES ===\n\n";

// Permisos
echo "PERMISOS REGISTRADOS:\n";
$permisos = Permission::all();
foreach ($permisos as $permiso) {
    echo "  - {$permiso->name}\n";
}
echo "Total: " . $permisos->count() . " permisos\n\n";

// Roles
echo "ROLES REGISTRADOS:\n";
$roles = Role::all();
foreach ($roles as $rol) {
    echo "  - {$rol->name} (Permisos: {$rol->permissions->count()})\n";
}
echo "Total: " . $roles->count() . " roles\n\n";

// Usuarios
echo "USUARIOS REGISTRADOS:\n";
$usuarios = User::all();
foreach ($usuarios as $usuario) {
    $rolesNames = $usuario->roles->pluck('name')->join(', ');
    echo "  - {$usuario->name} ({$usuario->email}) - Roles: {$rolesNames}\n";
}
echo "Total: " . $usuarios->count() . " usuarios\n";
