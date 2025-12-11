FROM php:8.3-fpm-alpine

# Instala nginx y extensiones necesarias
RUN apk add --no-cache nginx libpq nodejs npm \
    && apk add --no-cache --virtual .build-deps \
       $PHPIZE_DEPS libpng-dev libjpeg-turbo-dev freetype-dev libzip-dev postgresql-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd zip \
    && apk del .build-deps

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Código
WORKDIR /app
COPY . .

# Dependencias
RUN composer install --optimize-autoloader --no-dev --no-interaction
RUN npm install && npm run build && rm -rf node_modules

# Permisos
RUN chown -R www-data:www-data storage bootstrap/cache

# Nginx config
RUN echo 'server { \
    listen 8080; \
    root /app/public; \
    index index.php; \
    location / { try_files $uri $uri/ /index.php?$query_string; } \
    location ~ \.php$ { \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        include fastcgi_params; \
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
    } \
}' > /etc/nginx/http.d/default.conf

# Arranca todo
CMD php-fpm -D && nginx -g "daemon off;"