FROM php:8.3-fpm

RUN apt-get update && apt-get install -y git curl libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev zip unzip nginx supervisor && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip

RUN sed -i 's/listen = \/run\/php\/php8.3-fpm.sock/listen = 127.0.0.1:9000/' /usr/local/etc/php-fpm.d/www.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer config --global process-timeout 6000 && composer config --global allow-plugins true && composer config platform.php 8.3.13 && composer clear-cache && COMPOSER_MEMORY_LIMIT=-1 COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --prefer-dist && composer dump-autoload --optimize

COPY .tender/nginx/default.conf /etc/nginx/sites-available/default
COPY .tender/supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN mkdir -p /var/log/supervisor /run/php /var/log/nginx storage/framework/cache storage/framework/sessions storage/framework/views storage/logs && chown -R www-data:www-data storage bootstrap/cache && chmod -R 775 storage bootstrap/cache

ENV APP_ENV=production
ENV APP_DEBUG=true

EXPOSE 10000

RUN echo '#!/bin/bash' > /start.sh && echo 'set -e' >> /start.sh && echo 'echo "=== CASHDIGITAL STARTING ==="' >> /start.sh && echo 'ls -la public/index.php vendor/autoload.php' >> /start.sh && echo 'chown -R www-data:www-data storage bootstrap/cache' >> /start.sh && echo 'chmod -R 775 storage bootstrap/cache' >> /start.sh && echo 'php artisan config:clear' >> /start.sh && echo 'php artisan route:clear' >> /start.sh && echo 'php artisan cache:clear' >> /start.sh && echo 'php artisan migrate --force || true' >> /start.sh && echo 'php artisan config:cache' >> /start.sh && echo 'php artisan route:cache' >> /start.sh && echo 'php artisan route:list' >> /start.sh && echo 'exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf' >> /start.sh && chmod +x /start.sh

CMD ["/start.sh"]
