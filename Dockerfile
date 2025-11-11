# Base PHP 8.3 con Apache
FROM php:8.3-apache

# Instala dependencias del sistema y extensiones PHP necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip unzip git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_pgsql mbstring bcmath exif pcntl opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia la aplicación y establece permisos correctos
COPY . /var/www/html
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Cambia al usuario www-data para correr Composer
USER www-data

# Instala dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Vuelve a root para caches de Laravel y Apache
USER root

# Cache de Laravel
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Expone el puerto 80
EXPOSE 80

# Comando por defecto
CMD ["apache2-foreground"]
