-- Script para migrar datos de MySQL a PostgreSQL

-- 1. Crear base de datos en PostgreSQL
CREATE DATABASE cashdigital;

-- 2. Conectarse a la base de datos
\c cashdigital;

-- 3. Las tablas se crearán con las migraciones de Laravel
-- Este script es para referencia de conversión de tipos

-- Conversiones importantes de MySQL a PostgreSQL:
-- TINYINT -> SMALLINT o BOOLEAN
-- INT UNSIGNED -> INTEGER (sin unsigned en PostgreSQL)
-- DATETIME -> TIMESTAMP
-- TEXT -> TEXT (igual)
-- DECIMAL(7,2) UNSIGNED -> DECIMAL(7,2) con CHECK constraint

-- Si necesitas agregar constraints para simular UNSIGNED:
ALTER TABLE operaciones ADD CONSTRAINT operaciones_monto_pago_positive
    CHECK (monto_pago >= 0);

ALTER TABLE operaciones ADD CONSTRAINT operaciones_monto_comision_positive
    CHECK (monto_comision >= 0);

ALTER TABLE clientes ADD CONSTRAINT clientes_estado_positive
    CHECK (estado >= 0);
