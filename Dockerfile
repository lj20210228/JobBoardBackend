# Koristimo PHP + Apache image
FROM php:8.2-apache

# Instaliraj PHP ekstenzije i git, unzip
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    curl \
    && docker-php-ext-install pdo pdo_mysql zip mbstring

# Instaliraj Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Kopiraj ceo Laravel projekat
COPY . /var/www/html

WORKDIR /var/www/html

# Instaliraj PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Postavi prava
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Omogući Apache mod_rewrite
RUN a2enmod rewrite

# Preusmeri DocumentRoot na Laravel public folder
RUN sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]
