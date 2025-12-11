# Usamos la imagen oficial de Railway para Laravel (ya tiene todo instalado)
FROM railwayapp/php:8.3

# Cambiamos al directorio de trabajo
WORKDIR /app

# Copiamos el código
COPY . .

# Instalamos dependencias
RUN composer install --optimize-autoloader --no-dev --no-interaction
RUN npm install && npm run build && rm -rf node_modules

# Permisos
RUN chown -R www-data:www-data storage bootstrap/cache

# Exponemos el puerto que Railway espera
EXPOSE $PORT

# Comando de arranque que Railway entiende
CMD php artisan serve --host=0.0.0.0 --port=$PORT