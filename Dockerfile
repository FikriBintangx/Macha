FROM php:7.4-apache

# Install required system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pgsql pdo pdo_pgsql mysqli pdo_mysql

# Enable Apache mod_rewrite for CodeIgniter URLs
RUN a2enmod rewrite

# Copy project files to the container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Ensure proper permissions for the web server
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
