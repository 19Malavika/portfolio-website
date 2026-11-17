# Stage 1: Build Frontend Assets
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 2: Production PHP + Apache Environment
FROM php:8.2-apache
WORKDIR /var/www/html

# Install required system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    zip \
    unzip \
    sqlite3 \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath gd

# Configure Apache DocumentRoot to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# Copy Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application source code
COPY . .

# Copy Vite production build assets from Stage 1
COPY --from=frontend /app/public/build ./public/build

# Set permissions and initialize SQLite file
RUN mkdir -p database storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache
RUN touch database/database.sqlite
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Copy entrypoint startup script
COPY docker-start.sh /usr/local/bin/docker-start.sh
RUN tr -d '\r' < /usr/local/bin/docker-start.sh > /usr/local/bin/docker-start.sh.clean && \
    mv /usr/local/bin/docker-start.sh.clean /usr/local/bin/docker-start.sh && \
    chmod +x /usr/local/bin/docker-start.sh

EXPOSE 80

CMD ["/usr/local/bin/docker-start.sh"]
