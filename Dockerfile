FROM php:8.2-apache

# Enable necessary Apache modules
RUN a2enmod rewrite
RUN a2enmod headers

# Install required PHP extensions
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

# Configure Apache to serve from public directory
RUN echo '<Directory /var/www/html/public>' >> /etc/apache2/apache2.conf && \
    echo '  Options Indexes FollowSymLinks' >> /etc/apache2/apache2.conf && \
    echo '  AllowOverride All' >> /etc/apache2/apache2.conf && \
    echo '  Require all granted' >> /etc/apache2/apache2.conf && \
    echo '</Directory>' >> /etc/apache2/apache2.conf

# Set DocumentRoot to public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Cache busting and optimizations
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Expose port 8080 (Cloud Run requirement)
EXPOSE 8080

# Modify Apache to listen on 8080
RUN sed -i 's/Listen 80/Listen 8080/g' /etc/apache2/ports.conf

# Start Apache
CMD ["apache2-foreground"]


FROM php:8.2-fpm-alpine

# Installation des dépendances système nécessaires
RUN apk add --no-cache \
    nginx \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    oniguruma-dev

# Installation des extensions PHP requises par Laravel
RUN docker-php-ext-install pdo_mysql mbstring bcmath exif pcntl gd

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copie du projet
COPY . .

# Installation des dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Configuration des permissions pour Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Configuration minimale de Nginx pour Render
RUN mkdir -p /run/nginx
COPY .render/nginx.conf /etc/nginx/nginx.conf

EXPOSE 80

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
