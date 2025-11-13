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

# Copia TODO el proyecto
COPY . .

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
    composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts \
    --prefer-dist

# Dump autoload
RUN composer dump-autoload --optimize

# Copia configuraciones de Nginx y Supervisord
COPY .tender/nginx/default.conf /etc/nginx/sites-available/default
COPY .tender/supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Crea directorios necesarios y establece permisos
RUN mkdir -p /var/log/supervisor \
    && mkdir -p /run/php \
    && mkdir -p /var/log/nginx \
    && mkdir -p storage/framework/cache \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/logs \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Variables de entorno para Laravel
ENV APP_ENV=production
ENV APP_DEBUG=true

# Expone el puerto
EXPOSE 10000

# Crea script de inicio
COPY <<'EOF' /start.sh
#!/bin/bash
set -e

echo "=== Iniciando CashDigital ==="
echo ""

# Verificar archivos críticos
echo "Verificando estructura..."
ls -la public/index.php
ls -la vendor/autoload.php
echo ""

# Permisos
echo "Configurando permisos..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
echo ""

# Limpiar cachés
echo "Limpiando cachés..."
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear
echo ""

# Migraciones
echo "Ejecutando migraciones..."
php artisan migrate --force || echo "Migraciones omitidas"
echo ""

# Optimizar
echo "Optimizando aplicación..."
php artisan config:cache
php artisan route:cache
echo ""

# Listar rutas
echo "Rutas disponibles:"
php artisan route:list
echo ""

# Iniciar servicios
echo "Iniciando Nginx y PHP-FPM..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
EOF

RUN chmod +x /start.sh

CMD ["/start.sh"]
