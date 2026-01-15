# Base PHP 8.2 FPM
FROM php:8.2-fpm

# Instala dependências do sistema + gettext-base (para envsubst)
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libzip-dev zip unzip git curl nodejs npm \
    nginx supervisor gettext-base \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Diretório de trabalho
WORKDIR /var/www

# Copia apenas composer.json e composer.lock primeiro (para cache)
COPY composer.json composer.lock ./

# Instala dependências PHP
RUN composer install --no-dev --optimize-autoloader

# Copia todo o restante do projeto
COPY . .

# Permissões Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# Copia configs do Nginx e Supervisor
COPY docker/default.conf /etc/nginx/sites-available/default.template
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expõe porta do Railway
EXPOSE 8080

# Comando principal
CMD ["/entrypoint.sh"]
