# Koristimo PHP + Apache
FROM php:8.2-apache

# Instaliraj PHP ekstenzije i git/unzip
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    curl \
    && docker-php-ext-install pdo pdo_mysql zip mbstring

# Instaliraj Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Kopiraj Laravel projekat
COPY . /var/www/html

WORKDIR /var/www/html

# Instaliraj PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Postavi prava za storage i cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Omogući Apache mod_rewrite
RUN a2enmod rewrite

# Preusmeri DocumentRoot na Laravel public folder
RUN sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf

# Otvori port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
