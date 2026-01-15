# Usa PHP CLI (mais leve)
FROM php:8.2-cli

WORKDIR /var/www

# Copia só o composer antes
COPY composer.json composer.lock ./

# Instala dependências
RUN apt-get update && apt-get install -y unzip git curl zip \
    && docker-php-ext-install pdo pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader

# Copia o restante
COPY . .

# Permissões
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# Expõe porta que o Railway usará
EXPOSE 8080
ENV PORT 8080

# Serve Laravel na porta do Railway
CMD php artisan serve --host=0.0.0.0 --port=$PORT
