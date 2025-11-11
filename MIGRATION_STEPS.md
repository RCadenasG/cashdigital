# Pasos para Migrar de MySQL a PostgreSQL

## 1. Instalar PostgreSQL
- Descargar PostgreSQL desde: https://www.postgresql.org/download/windows/
- Instalar con las opciones por defecto
- Recordar el password del usuario postgres

## 2. Crear Base de Datos
```bash
# Abrir pgAdmin 4 o psql
# Crear base de datos: cashdigital
# Character set: UTF8
# Collation: Spanish_Spain.1252 o C
```

## 3. Configurar Laravel
```bash
# Actualizar archivo .env con credenciales de PostgreSQL
# Verificar que las extensiones de PHP estén habilitadas
```

## 4. Limpiar y Migrar
```bash
# Limpiar caché
php artisan config:clear
php artisan cache:clear

# Ejecutar migraciones
php artisan migrate:fresh

# Ejecutar seeders
php artisan db:seed

# O todo junto
php artisan migrate:fresh --seed
```

## 5. Migrar Datos Existentes (si aplica)
```bash
# Exportar datos de MySQL
mysqldump -u root -p cashdigital > cashdigital_mysql.sql

# Convertir SQL de MySQL a PostgreSQL
# Usar herramienta: pgloader o conversión manual

# Importar a PostgreSQL
psql -U postgres -d cashdigital -f cashdigital_postgres.sql
```

## 6. Verificar Funcionamiento
- Probar login
- Verificar CRUDs
- Revisar operaciones
- Comprobar cálculos de comisiones

## Diferencias Importantes MySQL vs PostgreSQL

### Tipos de Datos
- MySQL `INT UNSIGNED` → PostgreSQL `INTEGER` (usar CHECK constraints)
- MySQL `TINYINT` → PostgreSQL `SMALLINT` o `BOOLEAN`
- MySQL `DATETIME` → PostgreSQL `TIMESTAMP`

### Funciones
- MySQL `NOW()` → PostgreSQL `NOW()` o `CURRENT_TIMESTAMP`
- MySQL `CONCAT()` → PostgreSQL `CONCAT()` o `||`
- MySQL `IFNULL()` → PostgreSQL `COALESCE()`

### Consultas
- MySQL usa ` para escapar → PostgreSQL usa "
- MySQL es case-insensitive → PostgreSQL es case-sensitive
- PostgreSQL requiere `::` para casting explícito

## 7. Optimizaciones PostgreSQL
```sql
-- Crear índices adicionales si es necesario
CREATE INDEX idx_operaciones_fecha_tipo ON operaciones(fecha, tipo_pago);

-- Analizar tablas para optimizar queries
ANALYZE operaciones;
ANALYZE clientes;
ANALYZE users;
```
