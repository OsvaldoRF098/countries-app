FROM php:8.3-fpm

# Instala dependencias del sistema para PHP y PostgreSQL
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libonig-dev libxml2-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala Node.js 20 + npm correctamente (esto arregla el error)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest  # Actualiza npm si es necesario

# Directorio de trabajo
WORKDIR /var/www/html

# Copia el código
COPY . .

# Instala dependencias PHP
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Instala dependencias JS y build (ahora npm funciona)
RUN npm ci && npm run build

# Genera key, migra y importa a Algolia (en producción usa variables de Railway)
RUN php artisan key:generate --force

# Expone el puerto (Railway usa $PORT, pero lo sobreescribimos en railway.json)
EXPOSE ${PORT:-8000}

# Comando de inicio (usa artisan serve para simplicidad)
CMD php artisan migrate --force && php artisan scout:import "App\Models\Country" --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}