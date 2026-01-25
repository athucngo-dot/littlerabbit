FROM php:8.3-fpm

WORKDIR /var/www/html

# Install system deps + PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip curl \
    libxml2-dev libzip-dev libpng-dev libonig-dev \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install \
    pdo pdo_mysql mbstring zip exif pcntl bcmath xml \
    && rm -rf /var/lib/apt/lists/*

# Install Composer (runtime only, no install here)
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Permissions (works with bind mounts)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html

USER www-data

EXPOSE 9000
CMD ["php-fpm"]
# End of Dockerfile