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
          libxml2-dev \
          unzip \
          git \
          && docker-php-ext-install pdo pdo_mysql dom xml \
          && rm -rf /var/lib/apt/lists/*

# Copy app code
COPY . .

# Copy frontend build from Node stage
COPY --from=frontend /app/public/build ./public/build

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install PHP dependencies (prod only, skip scripts)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
          && chmod -R 775 storage bootstrap/cache

USER www-data
EXPOSE 9000
