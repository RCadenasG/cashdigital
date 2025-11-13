FROM php:8.3-fpm

# Instala dependencias del sistema incluyendo Nginx y Supervisor
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    nginx \
    supervisor \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instala extensiones de PHP
RUN docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Configura PHP-FPM para escuchar en puerto TCP
RUN sed -i 's/listen = \/run\/php\/php8.3-fpm.sock/listen = 127.0.0.1:9000/' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/;listen.owner = www-data/listen.owner = www-data/' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/;listen.group = www-data/listen.group = www-data/' /usr/local/etc/php-fpm.d/www.conf

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia archivos de composer primero
COPY composer.json composer.lock* ./

# Configura Composer
RUN composer config --global process-timeout 6000 && \
    composer config --global allow-plugins true && \
    composer config platform.php 8.3.13 && \
    composer config --global discard-changes true && \
    composer config --global preferred-install dist

# Limpia caché de Composer
RUN composer clear-cache

# Instala dependencias
RUN COMPOSER_MEMORY_LIMIT=-1 \
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_NO_INTERACTION=1 \
    composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts \
    --prefer-dist \
    --classmap-authoritative \
    2>&1 | tee /tmp/composer-install.log \
    || (echo "===== COMPOSER INSTALL FALLÓ =====" && \
        cat /tmp/composer-install.log && \
        echo "===== INTENTANDO UPDATE =====" && \
        COMPOSER_MEMORY_LIMIT=-1 \
        COMPOSER_ALLOW_SUPERUSER=1 \
        composer update \
        --no-dev \
        --optimize-autoloader \
        --no-interaction \
        --no-scripts \
        --prefer-dist \
        --classmap-authoritative)

# Copia el resto de la aplicación
COPY . .

# Ejecuta scripts post-install
RUN composer run-script post-autoload-dump --no-interaction || true

# Copia configuraciones de Nginx y Supervisord
COPY .tender/nginx/default.conf /etc/nginx/sites-available/default
COPY .tender/supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Crea directorios necesarios y establece permisos
RUN mkdir -p /var/log/supervisor \
    && mkdir -p /run/php \
    && mkdir -p /var/log/nginx \
    && mkdir -p /var/www/html/storage/framework/cache \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/logs \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Variables de entorno para Laravel
ENV APP_ENV=production
ENV APP_DEBUG=true

# Expone el puerto
EXPOSE 10000

# Crea script de inicio con diagnósticos
RUN printf '#!/bin/bash\n\
set -e\n\
echo "=== Verificando archivo index.php ==="\n\
if [ -f /var/www/html/public/index.php ]; then\n\
  echo "✓ index.php encontrado"\n\
  ls -lh /var/www/html/public/index.php\n\
else\n\
  echo "✗ ERROR: index.php NO encontrado"\n\
  exit 1\n\
fi\n\
echo ""\n\
echo "=== Verificando permisos ==="\n\
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache\n\
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache\n\
echo ""\n\
echo "=== Limpiando cachés ==="\n\
php artisan config:clear || true\n\
php artisan route:clear || true\n\
php artisan cache:clear || true\n\
php artisan view:clear || true\n\
echo ""\n\
echo "=== Ejecutando migraciones ==="\n\
php artisan migrate --force || echo "⚠ Migraciones fallaron, continuando..."\n\
echo ""\n\
echo "=== Cachear configuración ==="\n\
php artisan config:cache || true\n\
php artisan route:cache || true\n\
echo ""\n\
echo "=== Rutas registradas ==="\n\
php artisan route:list || true\n\
echo ""\n\
echo "=== Verificando variables de entorno críticas ==="\n\
php -r "echo \"APP_ENV: \" . env(\"APP_ENV\") . \"\\n\";" || true\n\
php -r "echo \"APP_KEY existe: \" . (env(\"APP_KEY\") ? \"SI\" : \"NO\") . \"\\n\";" || true\n\
php -r "echo \"DB_CONNECTION: \" . env(\"DB_CONNECTION\") . \"\\n\";" || true\n\
echo ""\n\
echo "=== Iniciando servicios ==="\n\
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf\n' > /start.sh \
    && chmod +x /start.sh

CMD ["/start.sh"]
