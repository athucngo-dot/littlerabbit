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

# Install PHP extensions (adjust if your app needs more)
RUN docker-php-ext-install pdo pdo_mysql

# Copy backend code
COPY . .

# Copy frontend build assets from previous stage
COPY --from=frontend /app/public/build ./public/build

# Set Laravel permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Switch to non-root user
USER www-data

# Expose port (if needed)
EXPOSE 9000
