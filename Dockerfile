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

# Configura PHP-FPM para escuchar en puerto TCP en lugar de socket
RUN sed -i 's/listen = \/run\/php\/php8.3-fpm.sock/listen = 127.0.0.1:9000/' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/;listen.owner = www-data/listen.owner = www-data/' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/;listen.group = www-data/listen.group = www-data/' /usr/local/etc/php-fpm.d/www.conf

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia archivos de composer primero
COPY composer.json composer.lock* ./

# Configura Composer con timeouts más largos
RUN composer config --global process-timeout 3000 && \
    composer config --global allow-plugins true && \
    composer config platform.php 8.3.13 && \
    composer config --global cache-dir /tmp/composer-cache && \
    composer config --global discard-changes true

# Intenta install primero, si falla usa update
RUN COMPOSER_MEMORY_LIMIT=-1 \
    COMPOSER_ALLOW_SUPERUSER=1 \
    composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts \
    --prefer-dist \
    --no-progress \
    --verbose \
    || (echo "Install falló, intentando update..." && \
    COMPOSER_MEMORY_LIMIT=-1 \
    COMPOSER_ALLOW_SUPERUSER=1 \
    composer update \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts \
    --prefer-dist \
    --no-progress \
    --verbose)

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
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Variables de entorno para Laravel
ENV APP_ENV=production
ENV APP_DEBUG=false

# Expone el puerto
EXPOSE 10000

# Crea script de inicio
RUN echo '#!/bin/bash\n\
set -e\n\
echo "Ejecutando migraciones..."\n\
php artisan migrate --force || echo "Migraciones fallaron, continuando..."\n\
echo "Optimizando aplicación..."\n\
php artisan config:cache || true\n\
php artisan route:cache || true\n\
php artisan view:cache || true\n\
echo "Iniciando servicios..."\n\
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf' > /start.sh \
    && chmod +x /start.sh

CMD ["/start.sh"]
