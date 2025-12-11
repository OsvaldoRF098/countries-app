FROM php:8.3-fpm-alpine

# 1. Instalar dependencias del sistema, Node.js Y OPENSSH
# Dividimos en pasos para evitar errores de red/memoria
RUN apk update && apk add --no-cache \
    nginx \
    libpq \
    nodejs \
    npm \
    openssh \
    dialog \
    bash \
    vim

# 2. Instalar dependencias de compilación
RUN apk add --no-cache --virtual .build-deps \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    postgresql-dev

# 3. Configurar extensiones PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo pdo_pgsql gd zip \
    && apk del .build-deps

# 4. CONFIGURACIÓN SSH PARA AZURE
# Establece la contraseña de root a "Docker!"
RUN echo "root:Docker!" | chpasswd

# Configuramos SSH modificando el archivo que ya trae Alpine por defecto
# (Eliminé la línea COPY que te daba error)
RUN ssh-keygen -A \
    && sed -i "s/#PermitRootLogin.*/PermitRootLogin yes/" /etc/ssh/sshd_config \
    && echo "Port 2222" >> /etc/ssh/sshd_config \
    && echo "PasswordAuthentication yes" >> /etc/ssh/sshd_config

# --- RESTO DE LA APP ---

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /home/site/wwwroot
COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction
RUN npm install && npm run build && rm -rf node_modules

RUN chown -R www-data:www-data storage bootstrap/cache

# Config Nginx
RUN echo 'server { \
    listen 8080; \
    root /home/site/wwwroot/public; \
    index index.php; \
    location / { try_files $uri $uri/ /index.php?$query_string; } \
    location ~ \.php$ { \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        include fastcgi_params; \
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
    } \
}' > /etc/nginx/http.d/default.conf

# --- SCRIPT DE INICIO ---
# Este script inicia SSH, PHP y Nginx al mismo tiempo
RUN echo "#!/bin/sh" > /start.sh && \
    echo "echo 'Iniciando servicios...'" >> /start.sh && \
    echo "/usr/sbin/sshd" >> /start.sh && \
    echo "php-fpm -D" >> /start.sh && \
    echo "nginx -g 'daemon off;'" >> /start.sh && \
    chmod +x /start.sh

CMD ["/start.sh"]