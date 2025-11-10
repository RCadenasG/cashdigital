# Guía Completa de Despliegue - CashDigital en Railway

## 📋 Requisitos Previos
- ✅ Proyecto Laravel CashDigital funcionando localmente
- ✅ Cuenta de GitHub
- ✅ **Git instalado en tu sistema** ✅ YA LO TIENES (ver configuración abajo)
- ✅ Composer instalado

### ✅ Git ya está instalado - Solo configuración

Ya tienes Git instalado (versión 2.47.0.windows.2) y GitHub Desktop. Solo necesitas verificar la configuración:

#### 1. Verificar configuración actual:
```bash
# Abrir Git Bash, CMD o PowerShell y ejecutar:
git config --global user.name
git config --global user.email
```

#### 2. Si no está configurado o quieres cambiarlo:
```bash
# Configurar tu nombre (reemplaza "Tu Nombre")
git config --global user.name "Tu Nombre"

# Configurar tu email (IMPORTANTE: usa el mismo email de tu cuenta GitHub)
git config --global user.email "tuemail@ejemplo.com"
```

#### 3. Verificar que está todo listo:
```bash
git --version          # Debería mostrar: git version 2.47.0.windows.2
git config --global user.name    # Tu nombre
git config --global user.email   # Tu email
```

#### Opciones para trabajar con Git:
- **Git Bash:** Terminal especializada para Git (recomendado)
- **GitHub Desktop:** Interfaz gráfica que ya tienes
- **CMD/PowerShell:** También funcionan
- **VS Code:** Integración completa con Git

---

## 🔧 PASO 1: Preparar el Proyecto Local

### 1.1 Optimizar Laravel para Producción
```bash
# Navegar al directorio del proyecto
cd c:\laragon\www\cashdigital

# Instalar dependencias optimizadas
composer install --optimize-autoloader --no-dev

# Limpiar cachés existentes
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Crear cachés optimizados
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 1.2 Crear Procfile

El **Procfile** le dice a Railway cómo ejecutar tu aplicación.

Crear archivo `Procfile` (sin extensión) en la raíz del proyecto:
```
web: php artisan serve --host=0.0.0.0 --port=$PORT
```

#### ¿Qué hace exactamente este comando?

**`web:`** 
- Define un proceso de tipo "web" (servidor HTTP)
- Railway reconoce esto como el servidor principal de tu app

**`php artisan serve`**
- Inicia el servidor web integrado de Laravel
- Es el comando nativo de Laravel para desarrollo/producción ligera

**`--host=0.0.0.0`**
- Hace que el servidor escuche en TODAS las interfaces de red
- Por defecto Laravel solo escucha en `127.0.0.1` (localhost)
- En Railway necesitas `0.0.0.0` para que sea accesible desde internet

**`--port=$PORT`**
- `$PORT` es una variable de entorno que Railway define automáticamente
- Railway asigna un puerto dinámico (ej: 8080, 3000, etc.)
- Sin esto, Laravel usaría puerto 8000 por defecto y fallaría

#### Comparación:
```bash
# Local (Laragon):
php artisan serve
# Resultado: http://127.0.0.1:8000 (solo local)

# Railway:
php artisan serve --host=0.0.0.0 --port=$PORT
# Resultado: https://tuapp.railway.app (accesible desde internet)
```

#### Alternativas para el Procfile:
```bash
# Opción actual (recomendada):
web: php artisan serve --host=0.0.0.0 --port=$PORT

# Con Apache/Nginx (más complejo):
web: vendor/bin/heroku-php-apache2 public/

# Con configuración adicional:
web: php artisan config:cache && php artisan serve --host=0.0.0.0 --port=$PORT
```

**⚠️ IMPORTANTE:** 
- El archivo debe llamarse exactamente `Procfile` (sin extensión)
- Debe estar en la raíz del proyecto (no en una subcarpeta)
- Railway ejecuta este comando automáticamente al hacer deploy

### 1.3 Modificar .env para Producción
Crear archivo `.env.production` con las siguientes variables:
```env
APP_NAME="CashDigital"
APP_ENV=production
APP_KEY=base64:TU_CLAVE_AQUI
APP_DEBUG=false
APP_URL=https://cashdigital-production.up.railway.app

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=${MYSQL_HOST}
DB_PORT=${MYSQL_PORT}
DB_DATABASE=${MYSQL_DATABASE}
DB_USERNAME=${MYSQL_USER}
DB_PASSWORD=${MYSQL_PASSWORD}

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### 1.4 Crear Script de Build
Crear archivo `build.sh` en la raíz:
```bash
#!/bin/bash
echo "Iniciando build para producción..."

# Instalar dependencias de composer
composer install --optimize-autoloader --no-dev

# Instalar dependencias de npm
npm ci

# Construir assets
npm run build

# Ejecutar migraciones
php artisan migrate --force

# Crear enlace de storage
php artisan storage:link

# Limpiar y cachear configuraciones
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Build completado!"
```

### 1.5 Verificar Archivos Importantes
Asegúrate que estos archivos existan:
- ✅ `composer.json`
- ✅ `package.json`
- ✅ `Procfile`
- ✅ `build.sh`
- ✅ `.env.production`

## 🐙 PASO 2: Subir a GitHub

### 2.1 Inicializar Git (si no está inicializado)
```bash
git init
```

### 2.2 Configurar .gitignore
Verificar que `.gitignore` contenga:
```
/vendor
/node_modules
.env
.env.backup
.env.production
.phpunit.result.cache
Homestead.json
Homestead.yaml
auth.json
npm-debug.log
yarn-error.log
/.fleet
/.idea
/.vscode
/storage/*.key
/storage/app/public
/storage/framework/cache
/storage/framework/sessions
/storage/framework/testing
/storage/framework/views
/storage/logs
/bootstrap/cache
/public/build
/public/hot
```

### 2.3 Crear Repositorio en GitHub
1. Ir a [github.com](https://github.com)
2. Click en "New repository"
3. Nombre: `cashdigital`
4. Descripción: "Sistema de transferencias CashDigital"
5. Público o Privado (tu elección)
6. NO marcar "Add README"
7. Click "Create repository"

### 2.4 Subir Código
```bash
# Agregar archivos
git add .

# Hacer commit
git commit -m "Initial commit - CashDigital sistema completo"

# Agregar origen remoto (reemplaza TUUSUARIO)
git remote add origin https://github.com/TUUSUARIO/cashdigital.git

# Cambiar a rama main
git branch -M main

# Subir código
git push -u origin main
```

## 🚂 PASO 3: Configurar Railway

### 3.1 Crear Cuenta en Railway
1. Ir a [railway.app](https://railway.app)
2. Click "Login"
3. Seleccionar "Login with GitHub"
4. Autorizar Railway en GitHub

### 3.2 Crear Nuevo Proyecto
1. En el dashboard de Railway, click "New Project"
2. Seleccionar "Deploy from GitHub repo"
3. Buscar y seleccionar `cashdigital`
4. Click "Deploy"

### 3.3 Agregar Base de Datos MySQL
1. En tu proyecto Railway, click "New"
2. Seleccionar "Database"
3. Click "Add MySQL"
4. Esperar que se provisione (2-3 minutos)

### 3.4 Configurar Variables de Entorno
1. Click en el servicio de tu aplicación (no la base de datos)
2. Ir a la pestaña "Variables"
3. Agregar las siguientes variables una por una **EXACTAMENTE COMO ESTÁN:**

```env
APP_NAME=CashDigital
APP_ENV=production
APP_KEY=base64:GENERAR_NUEVA_CLAVE
APP_DEBUG=false
APP_URL=${{RAILWAY_STATIC_URL}}

DB_CONNECTION=mysql
DB_HOST=${{MYSQL_HOST}}
DB_PORT=${{MYSQL_PORT}}
DB_DATABASE=${{MYSQL_DATABASE}}
DB_USERNAME=${{MYSQL_USER}}
DB_PASSWORD=${{MYSQL_PASSWORD}}

SESSION_DRIVER=database
CACHE_DRIVER=database
LOG_CHANNEL=single
```

#### ⚠️ IMPORTANTE sobre las variables ${{}}:

**NO reemplaces estas variables:**
- `${{MYSQL_HOST}}` - Railway lo reemplaza automáticamente
- `${{MYSQL_PORT}}` - Railway lo reemplaza automáticamente  
- `${{MYSQL_DATABASE}}` - Railway lo reemplaza automáticamente
- `${{MYSQL_USER}}` - Railway lo reemplaza automáticamente
- `${{MYSQL_PASSWORD}}` - Railway lo reemplaza automáticamente
- `${{RAILWAY_STATIC_URL}}` - Railway lo reemplaza automáticamente

#### Cómo funciona:
```bash
# Tú configuras en Railway:
DB_HOST=${{MYSQL_HOST}}

# Railway automáticamente lo convierte a:
DB_HOST=mysql.railway.internal

# Tú configuras:
DB_PORT=${{MYSQL_PORT}}

# Railway lo convierte a:
DB_PORT=3306
```

#### Variables que SÍ debes reemplazar:
- `APP_KEY=base64:GENERAR_NUEVA_CLAVE` ← Aquí sí pones tu clave generada
- `APP_NAME=CashDigital` ← Aquí sí pones el nombre que quieras

**En resumen:** Las variables con `${{}}` las dejas exactamente así, Railway las reemplaza automáticamente cuando conecta la base de datos.

### 3.5 Generar APP_KEY

**IMPORTANTE:** No uses "TU_CLAVE_AQUI". Debes generar una clave única para tu aplicación.

#### Opción 1: Generar nueva clave (Recomendado)
```bash
# En tu terminal local (Git Bash, CMD o PowerShell):
cd c:\laragon\www\cashdigital
php artisan key:generate --show
```

**Ejemplo de resultado:**
```
base64:AB12cd34EF56gh78IJ90kl12MN34op56QR78st90UV12wx34YZ56ab78CD90==
```

#### Opción 2: Usar tu clave actual del .env local
```bash
# Ver tu clave actual:
type .env | findstr APP_KEY
# O en Git Bash:
cat .env | grep APP_KEY
```

**Ejemplo de resultado:**
```
APP_KEY=base64:xyz123abc456def789ghi012jkl345mno678pqr901stu234vwx567yz890==
```

#### Qué copiar exactamente en Railway:
Copia **TODO** incluyendo `base64:`, por ejemplo:
```
base64:AB12cd34EF56gh78IJ90kl12MN34op56QR78st90UV12wx34YZ56ab78CD90==
```

#### En Railway Variables:
- **Variable:** `APP_KEY`
- **Valor:** `base64:TU_CLAVE_GENERADA_AQUI`

**⚠️ IMPORTANTE:** 
- NO uses la misma clave en producción que en desarrollo
- SIEMPRE genera una nueva para Railway
- NUNCA compartas tu APP_KEY públicamente

## 🔧 PASO 4: Configurar Scripts de Build

### 4.1 Configurar Comando de Build
1. En Railway, ir a "Settings"
2. En "Build Command" poner:
```bash
npm ci && npm run build && composer install --optimize-autoloader --no-dev
```

### 4.2 Configurar Comando de Start
1. En "Start Command" poner:
```bash
php artisan migrate --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=$PORT
```

## 🚀 PASO 5: Deploy y Verificación

### 5.1 Ejecutar Deploy
1. Ir a "Deployments"
2. Click "Trigger Deploy"
3. Monitorear los logs de build

### 5.2 Verificar Migraciones
Si las migraciones fallan, ejecutar manualmente:
1. Ir a la pestaña "Data" de MySQL
2. Ejecutar:
```sql
CREATE DATABASE IF NOT EXISTS railway;
```

### 5.3 Configurar Dominio (Opcional)
1. Ir a "Settings"
2. En "Domains" click "Generate Domain"
3. Tu app estará disponible en: `https://tuapp.railway.app`

## 🔍 PASO 6: Verificación Final

### 6.1 Checklist de Verificación
- ✅ La aplicación carga sin errores
- ✅ Las rutas funcionan correctamente
- ✅ La base de datos está conectada
- ✅ Los assets CSS/JS cargan
- ✅ Las imágenes se muestran
- ✅ El login funciona

### 6.2 Comandos de Debug (si hay problemas)
En Railway, ir a la terminal y ejecutar:
```bash
# Ver logs
php artisan log:clear

# Verificar configuración
php artisan config:show

# Verificar rutas
php artisan route:list

# Verificar migraciones
php artisan migrate:status
```

## 🛠️ PASO 7: Configuraciones Adicionales

### 7.1 Configurar HTTPS
Railway automáticamente proporciona HTTPS, pero verifica en `.env`:
```env
APP_URL=https://tudominio.railway.app
ASSET_URL=https://tudominio.railway.app
```

### 7.2 Configurar Storage para Archivos
```bash
# En Railway terminal:
php artisan storage:link
```

### 7.3 Configurar Email (Opcional)
Para emails en producción, agregar variables:
```env
MAIL_MAILER=smtp
MAIL_HOST=tu-servidor-smtp
MAIL_PORT=587
MAIL_USERNAME=tu-email
MAIL_PASSWORD=tu-password
MAIL_ENCRYPTION=tls
```

## 🚨 Solución de Problemas Comunes

### Error de APP_KEY
```bash
# Generar nueva clave:
php artisan key:generate --show
# Copiar resultado a variable APP_KEY en Railway
```

### Error de Base de Datos
```bash
# Verificar conexión:
php artisan tinker
DB::select('SELECT 1');
```

### Error de Assets
```bash
# Reconstruir assets:
npm run build
```

### Error 500
```bash
# Ver logs detallados:
php artisan log:clear
# Luego revisar logs en Railway
```

## 📞 Soporte

- **Railway Docs**: [docs.railway.app](https://docs.railway.app)
- **Laravel Docs**: [laravel.com/docs](https://laravel.com/docs)
- **GitHub Issues**: Crear issue en tu repositorio

## 🎉 ¡Éxito!

Tu aplicación CashDigital debería estar funcionando en:
`https://tuapp.railway.app`

**Credenciales de prueba:**
- Usuario: admin@cashdigital.com
- Contraseña: (la que configuraste en tu seeder)

---
*Guía creada para el proyecto CashDigital*
*Fecha: $(date)*
