# =============================
# Stage 1 — Frontend build
# =============================
FROM node:20-alpine AS frontend

# Set working directory
WORKDIR /app

# Copy only package files first (caches npm install)
COPY package.json package-lock.json ./

# Install dependencies
RUN npm ci

# Copy the rest of the app
COPY . .

# Build the frontend assets (Vite, etc.)
RUN npm run build

# =============================
# Stage 2 — PHP runtime
# =============================
FROM php:8.3-fpm

WORKDIR /var/www/html

# Install PHP extensions
RUN apt-get update && apt-get install -y \
          git \
          unzip \
          curl \
          libxml2-dev \
          libzip-dev \
          libpng-dev \
          libonig-dev \
          && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath xml \
          && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Copy composer files first for caching
COPY composer.json composer.lock ./

# Install PHP dependencies (prod only, skip scripts)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy app code
COPY . .

# Copy frontend build from Node stage
COPY --from=frontend /app/public/build ./public/build

# Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
          && chmod -R 775 storage bootstrap/cache

USER www-data
EXPOSE 9000

CMD ["php-fpm"]