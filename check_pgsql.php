<?php
echo "PHP Version: " . phpversion() . "\n";
echo "PDO Drivers: " . implode(', ', PDO::getAvailableDrivers()) . "\n";
echo "PostgreSQL Support: " . (extension_loaded('pgsql') ? 'Yes' : 'No') . "\n";
echo "PDO PostgreSQL Support: " . (extension_loaded('pdo_pgsql') ? 'Yes' : 'No') . "\n";

if (extension_loaded('pdo_pgsql')) {
    echo "\n✓ PostgreSQL está habilitado correctamente\n";
} else {
    echo "\n✗ ERROR: PostgreSQL NO está habilitado\n";
    echo "Pasos para solucionar:\n";
    echo "1. Abrir: c:\\laragon\\bin\\php\\php-" . PHP_VERSION . "\\php.ini\n";
    echo "2. Buscar: ;extension=pdo_pgsql\n";
    echo "3. Quitar el punto y coma: extension=pdo_pgsql\n";
    echo "4. Buscar: ;extension=pgsql\n";
    echo "5. Quitar el punto y coma: extension=pgsql\n";
    echo "6. Reiniciar Laragon\n";
}

phpinfo(INFO_MODULES);
