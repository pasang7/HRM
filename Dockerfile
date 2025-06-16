# Use official PHP 7.4 Apache image
FROM php:7.4-apache

# Install system dependencies and PHP extensions, including gd with JPEG & FreeType support
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

# Install composer (copy from official composer image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files to container
COPY . /var/www/html

# Install PHP dependencies via composer
RUN composer install --no-dev --optimize-autoloader

# Set permissions for storage and cache folders
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port 80 for Apache
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
