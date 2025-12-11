```dockerfile
FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libonig-dev libxml2-dev libzip-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www/html

COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction
RUN npm ci && npm run build

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Exponemos el puerto que Railway nos da
EXPOSE $PORT

# INICIA EL SERVIDOR PRIMERO → luego ejecuta lo demás en background
CMD php artisan serve --host=0.0.0.0 --port=$PORT & \
    sleep 5 && \
    php artisan key:generate --force && \
    php artisan migrate --force --no-interaction && \
    php artisan scout:import "App\\Models\\Country" --quiet && \
    wait