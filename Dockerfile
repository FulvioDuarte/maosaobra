FROM php:8.2-cli

WORKDIR /var/www

# Copia apenas composer.json e composer.lock
COPY composer.json composer.lock ./

# Instala PHP + dependências
RUN apt-get update && apt-get install -y unzip git curl zip \
    && docker-php-ext-install pdo pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader

# Copia o restante do projeto
COPY . .

# Permissões Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8080
ENV PORT 8080

CMD php artisan serve --host=0.0.0.0 --port=$PORT
