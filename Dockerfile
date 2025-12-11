FROM php:8.3-fpm

# Instala dependencias del sistema para PHP y PostgreSQL
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libonig-dev libxml2-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala Node.js 20 + npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Directorio de trabajo
WORKDIR /var/www/html

# Copia el código
COPY . .

# Instala dependencias PHP
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Instala dependencias JS y build
RUN npm ci && npm run build

# Permisos para Laravel (evita errores en storage/logs)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Expone el puerto
EXPOSE ${PORT:-8000}

# Comando de inicio (migra y seed en runtime, no en build)
CMD php artisan migrate --force && php artisan scout:import "App\Models\Country" --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}