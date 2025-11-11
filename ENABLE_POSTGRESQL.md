# Habilitar PostgreSQL en Laragon

## Paso 1: Localizar php.ini
1. Abrir Laragon
2. Click derecho en el icono de Laragon en la bandeja del sistema
3. Ir a: PHP > php.ini
4. O abrir manualmente: `c:\laragon\bin\php\php-8.x.x\php.ini`

## Paso 2: Editar php.ini
Buscar estas líneas (generalmente están hacia el final del archivo):

```ini
;extension=pdo_pgsql
;extension=pgsql
```

Quitar el punto y coma (;) al inicio:

```ini
extension=pdo_pgsql
extension=pgsql
```

## Paso 3: Guardar y Reiniciar
1. Guardar el archivo php.ini
2. Cerrar Laragon completamente
3. Abrir Laragon nuevamente
4. Reiniciar todos los servicios

## Paso 4: Verificar
Ejecutar en terminal:
```bash
php check_pgsql.php
```

O crear un archivo PHP temporal:
```php
<?php phpinfo(); ?>
```

Buscar "pgsql" en la salida.

## Si aún no funciona:

### Opción A: Verificar que existan los archivos DLL
Verificar que existan estos archivos:
- `c:\laragon\bin\php\php-8.x.x\ext\php_pgsql.dll`
- `c:\laragon\bin\php\php-8.x.x\ext\php_pdo_pgsql.dll`

Si no existen, reinstalar PHP en Laragon.

### Opción B: Agregar ruta de PostgreSQL al PATH
1. Buscar la carpeta de PostgreSQL: `C:\Program Files\PostgreSQL\16\bin`
2. Agregar al PATH del sistema
3. Reiniciar Laragon

### Opción C: Copiar libpq.dll
1. Copiar `libpq.dll` de `C:\Program Files\PostgreSQL\16\bin\`
2. Pegar en `c:\laragon\bin\php\php-8.x.x\`
3. Reiniciar Laragon
