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
COPY .ten
