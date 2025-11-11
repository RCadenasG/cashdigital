<?php
echo "=== DIAGNÓSTICO POSTGRESQL ===\n\n";

// 1. Versión de PHP
echo "1. PHP Version: " . phpversion() . "\n\n";

// 2. Extensiones cargadas
echo "2. Extensiones PDO disponibles:\n";
$pdoDrivers = PDO::getAvailableDrivers();
foreach ($pdoDrivers as $driver) {
    echo "   - $driver\n";
}
echo "\n";

// 3. PostgreSQL
echo "3. PostgreSQL Extension: " . (extension_loaded('pgsql') ? '✓ SI' : '✗ NO') . "\n";
echo "4. PDO PostgreSQL Extension: " . (extension_loaded('pdo_pgsql') ? '✓ SI' : '✗ NO') . "\n\n";

// 4. Ruta de php.ini
echo "5. Archivo php.ini: " . php_ini_loaded_file() . "\n\n";

// 5. Extension dir
echo "6. Extension directory: " . ini_get('extension_dir') . "\n\n";

// 6. Verificar archivos DLL
$extDir = ini_get('extension_dir');
$pgsqlDll = $extDir . DIRECTORY_SEPARATOR . 'php_pgsql.dll';
$pdoPgsqlDll = $extDir . DIRECTORY_SEPARATOR . 'php_pdo_pgsql.dll';

echo "7. Verificar archivos DLL:\n";
echo "   php_pgsql.dll: " . (file_exists($pgsqlDll) ? '✓ Existe' : '✗ No existe') . "\n";
echo "   php_pdo_pgsql.dll: " . (file_exists($pdoPgsqlDll) ? '✓ Existe' : '✗ No existe') . "\n\n";

// 7. Test de conexión
if (extension_loaded('pdo_pgsql')) {
    echo "8. Probando conexión a PostgreSQL...\n";
    try {
        $dsn = "pgsql:host=127.0.0.1;port=5432;dbname=postgres";
        $pdo = new PDO($dsn, 'postgres', 'postgres');
        echo "   ✓ Conexión exitosa a PostgreSQL\n\n";
    } catch (PDOException $e) {
        echo "   ✗ Error de conexión: " . $e->getMessage() . "\n\n";
    }
} else {
    echo "8. ✗ No se puede probar conexión (extensión no cargada)\n\n";
}

// 8. Instrucciones
if (!extension_loaded('pdo_pgsql')) {
    echo "=== INSTRUCCIONES PARA SOLUCIONAR ===\n\n";
    echo "1. Abrir: " . php_ini_loaded_file() . "\n";
    echo "2. Buscar las líneas:\n";
    echo "   ;extension=pdo_pgsql\n";
    echo "   ;extension=pgsql\n";
    echo "3. Quitar el punto y coma (;) del inicio\n";
    echo "4. Guardar el archivo\n";
    echo "5. Reiniciar Laragon completamente\n";
    echo "6. Volver a ejecutar: php diagnostico.php\n";
}
