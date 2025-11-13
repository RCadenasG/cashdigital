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

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia archivos de composer
COPY composer.json composer.lock* ./

# Configura Composer
RUN composer config --global process-timeout 2000 && \
    composer config --global allow-plugins true && \
    composer config platform.php 8.3.13

# Usa UPDATE para regenerar el lock file y resolver conflictos
RUN COMPOSER_MEMORY_LIMIT=-1 \
    COMPOSER_ALLOW_SUPERUSER=1 \
    composer update \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts \
    --prefer-dist

# Copia el resto de la aplicación
COPY . .

# Ejecuta scripts post-install
RUN composer run-script post-autoload-dump --no-interaction || true

# Copia configuraciones de Nginx y Supervisord
COPY .tender/nginx/default.conf /etc/nginx/sites-available/default
COPY .tender/supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Crea directorios necesarios
RUN mkdir -p /var/log/supervisor \
    && mkdir -p /run/php

# Establece permisos
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/storage && \
    chmod -R 755 /var/www/html/bootstrap/cache

# Variables de entorno para Laravel
ENV APP_ENV=production
ENV APP_DEBUG=false

# Expone el puerto
EXPOSE 10000

# Crea script de inicio
RUN echo '#!/bin/bash\n\
php artisan migrate --force || echo "Migraciones fallaron, continuando..."\n\
php artisan config:cache || true\n\
php artisan route:cache || true\n\
php artisan view:cache || true\n\
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf' > /start.sh \
    && chmod +x /start.sh

CMD ["/start.sh"]
