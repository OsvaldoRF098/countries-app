# Imagen oficial de Laravel para Railway (ya tiene Composer, nginx, php-fpm83, todo)
FROM dunglas/frankenphp

# Cambia al directorio de trabajo
WORKDIR /app

# Copia tu código
COPY . .

# Instala dependencias
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-scripts \
    && composer dump-autoload --optimize \
    && npm install && npm run build && rm -rf node_modules

# Permisos
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose el puerto que Railway espera
ENV SERVER_NAME=:${PORT:-3000}

# Comando de arranque (FrankenPHP ya sirve Laravel perfecto)
CMD ["php", "artisan", "octane:frankenphp", "--host=0.0.0.0", "--port=${PORT:-3000}"]