FROM php:8.3-fpm-alpine

# Instala Composer y Node.js
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    git \
    libpng libjpeg-turbo freetype libzip libpq \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apk add --no-cache nodejs npm \
    && apk add --no-cache --virtual .build-deps \
       $PHPIZE_DEPS libpng-dev libjpeg-turbo-dev freetype-dev libzip-dev postgresql-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd zip \
    && apk del .build-deps

# Copia código
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

# Supervisor para arrancar todo
RUN echo '[supervisord] \
nodaemon=true \
\
[program:php-fpm] \
command=/usr/local/sbin/php-fpm83 \
autostart=true \
autorestart=true \
\
[program:nginx] \
command=/usr/sbin/nginx -g "daemon off;" \
autostart=true \
autorestart=true' > /etc/supervisord.conf

EXPOSE 8080
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]