# Use official PHP 7.4 Apache image
FROM php:7.4-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql zip mbstring xml \
    && a2enmod rewrite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Change Apache document root to /var/www/html/public (Laravel's public folder)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# Install composer (copy from official composer image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Allow running composer as root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Set temporary environment variables to skip DB connection during composer install
ENV APP_ENV=local
ENV DB_CONNECTION=null

# Install PHP dependencies but skip scripts (avoid DB connection errors)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Set correct permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port 80
EXPOSE 80

# Use entrypoint script to run artisan package:discover and start Apache
ENTRYPOINT ["docker-entrypoint.sh"]
