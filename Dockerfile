# 1️⃣ Imagen base de PHP con Apache
FROM php:8.2-apache

# 2️⃣ Instala librerías del sistema y dependencias de PHP necesarias para Laravel y GD
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    zip unzip git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_pgsql mbstring bcmath exif pcntl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 3️⃣ Instala Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4️⃣ Copia la aplicación al contenedor
COPY . /var/www/html
WORKDIR /var/www/html

# 5️⃣ Configura permisos correctos para Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 6️⃣ Instala dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# 7️⃣ Cache de Laravel para producción
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# 8️⃣ Expone el puerto 80 para Render
EXPOSE 80

# 9️⃣ Comando por defecto para correr Apache
CMD ["apache2-foreground"]
