FROM php:8.2-fpm

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    pkg-config \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# Extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# Permissões Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# Dependências PHP
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Variável de porta do Railway
ENV PORT 8080

# Expõe a porta
EXPOSE $PORT

# Servidor embutido do Laravel
CMD php artisan serve --host=0.0.0.0 --port=$PORT
