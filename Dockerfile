FROM php:8.2-apache

# Instaliraj sistemske zavisnosti i PHP ekstenzije (dodat bcmath)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    curl \
    && docker-php-ext-install pdo pdo_mysql zip mbstring bcmath

# Instaliraj Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Kopiraj projekat
COPY . /var/www/html

WORKDIR /var/www/html

# Instaliraj PHP dependencies bez dev alata
RUN composer install --no-dev --optimize-autoloader

# Postavi DocumentRoot na /public I OMOGUĆI .htaccess (AllowOverride All)
RUN sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf \
    && sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Omogući Apache mod_rewrite
RUN a2enmod rewrite

# Postavi prava za storage i cache (775 je sigurnije od 777)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]
