FROM php:8.3-fpm

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Node.js + npm
COPY --from=node:20 /usr/local/bin/node /usr/bin/node
COPY --from=node:20 /usr/local/lib/node_modules/npm /usr/local/lib/node_modules/npm

WORKDIR /var/www/html

COPY . .

RUN composer install --optimize-autoloader --no-dev
RUN npm install && npm run build

RUN php artisan key:generate --force
RUN php artisan migrate --force
RUN php artisan scout:import "App\Models\Country" --force

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000