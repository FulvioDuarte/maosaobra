# Base PHP 8.2 FPM
FROM php:8.2-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libzip-dev zip unzip git curl nodejs npm \
    nginx supervisor \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Diretório de trabalho
WORKDIR /var/www

# Copia todo o projeto
COPY . .

# Permissões Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# Instala dependências PHP
RUN composer install --no-dev --optimize-autoloader

# Copia configurações do Nginx e Supervisor
COPY docker/default.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expõe a porta que o Railway vai usar
EXPOSE 8080

# Comando principal: inicia Supervisor que roda PHP-FPM + Nginx
CMD ["/usr/bin/supervisord", "-n"]
