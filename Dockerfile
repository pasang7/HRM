# Use official PHP 7.4 Apache image (Laravel 6 supports PHP 7.2+, 7.4 is a safe choice)
FROM php:7.4-apache

# Install system dependencies and PHP extensions needed by Laravel + your composer.json packages
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    && docker-php-ext-install pdo_mysql zip mbstring xml \
    && a2enmod rewrite

# Install composer globally
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory inside container
WORKDIR /var/www/html

# Copy app files to container
COPY . /var/www/html

# Run composer install (no dev dependencies, optimized autoloader)
RUN composer install --no-dev --optimize-autoloader

# Set permissions for Laravel storage and cache directories
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port 80
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]
