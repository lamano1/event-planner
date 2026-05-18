FROM php:8.2-fpm

# Install necessary packages
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    && docker-php-ext-install -j$(nproc) \
    gd \
    pdo \
    pdo_mysql \
    mbstring \
    xml \
    curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Install Node dependencies and build assets
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install \
    && npm run build

# Generate application key
RUN php artisan key:generate

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Configure PHP-FPM
RUN mkdir -p /run/php && \
    chown -R www-data:www-data /run/php

# Configure Nginx
COPY .render/nginx.conf /etc/nginx/sites-available/default
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default && \
    rm -f /etc/nginx/sites-enabled/default.conf

# Create startup script for Cloud Run
RUN echo '#!/bin/bash\n\
php-fpm -D\n\
nginx -g "daemon off;"\n\
' > /start.sh && chmod +x /start.sh

# Cache busting and optimizations
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Expose port 8080 (Cloud Run requirement)
EXPOSE 8080

# Start services
CMD ["/start.sh"]
