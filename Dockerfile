FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    curl \
    && docker-php-ext-install pdo pdo_mysql zip mbstring

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html
WORKDIR /var/www/html

RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache
RUN a2enmod rewrite

EXPOSE 80
CMD ["apache2-foreground"]
