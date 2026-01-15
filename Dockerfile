# Base PHP CLI
FROM php:8.2-cli

WORKDIR /var/www

# Copia o projeto
COPY . .
 
# Instala dependências do sistema e PHP
RUN apt-get update && apt-get install -y unzip git curl zip nodejs npm \
    && docker-php-ext-install pdo pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader

# Permissões Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# Expõe a porta usada pelo Railway
EXPOSE 8080

# Porta fornecida pelo Railway
ENV PORT 8080

# Comando principal: PHP Built-in server do Laravel
CMD php artisan serve --host=0.0.0.0 --port=$PORT
