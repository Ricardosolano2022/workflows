# Dockerfile para Guestbook (PHP + Apache + ext-redis)
FROM php:8.1-apache

# Instalar dependencias y phpredis
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
        git zip unzip libzip-dev \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copiar la app
WORKDIR /var/www/html
COPY . /var/www/html

# Ajustar permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]